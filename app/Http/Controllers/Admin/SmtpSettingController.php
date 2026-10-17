<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class SmtpSettingController extends Controller
{
    public function index()
    {
        $smtp = CmsSetting::where('group', 'smtp')->orderBy('id')->get();
        return view('admin.settings.smtp', compact('smtp'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'settings.smtp_host'       => 'required|string',
            'settings.smtp_port'       => 'required|integer',
            'settings.smtp_username'   => 'required|string',
            'settings.smtp_password'   => 'nullable|string',
            'settings.smtp_encryption' => 'required|in:tls,ssl,none',
            'settings.smtp_from_name'  => 'required|string|max:100',
            'settings.smtp_from_email' => 'required|email',
        ]);

        foreach ($request->input('settings', []) as $key => $value) {
            // Do not overwrite password if left blank
            if ($key === 'smtp_password' && empty($value)) {
                continue;
            }
            CmsSetting::set($key, $value);
        }

        return back()->with('success', 'SMTP settings saved successfully.');
    }

    public function test(Request $request)
    {
        $request->validate(['test_email' => 'required|email']);

        $smtp = CmsSetting::getGroup('smtp');

        Config::set('mail.mailers.smtp.host',       $smtp['smtp_host']);
        Config::set('mail.mailers.smtp.port',        $smtp['smtp_port'] ?? 587);
        Config::set('mail.mailers.smtp.username',    $smtp['smtp_username']);
        Config::set('mail.mailers.smtp.password',    $smtp['smtp_password']);
        Config::set('mail.mailers.smtp.encryption',  $smtp['smtp_encryption'] ?? 'tls');
        Config::set('mail.from.address',             $smtp['smtp_from_email']);
        Config::set('mail.from.name',                $smtp['smtp_from_name']);
        Config::set('mail.default', 'smtp');

        try {
            Mail::raw(
                "✅ This is a test email from MH Trade Capital Solutions admin panel.\nYour SMTP configuration is working correctly.",
                fn ($msg) => $msg->to($request->test_email)->subject('SMTP Test — MH Trade Capital')
            );
            return back()->with('success', 'Test email sent successfully to ' . $request->test_email);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed: ' . $e->getMessage());
        }
    }
}
