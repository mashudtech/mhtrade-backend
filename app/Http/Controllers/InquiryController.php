<?php

namespace App\Http\Controllers;

use App\Mail\NewInquiryMail;
use App\Models\CmsSetting;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class InquiryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vertical' => 'required|in:lc,uae-banking,project,commodity,general',
            'name'     => 'required|string|max:255',
            'company'  => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'email'    => 'required|email|max:255',
            'phone'    => 'nullable|string|max:50',
            'country'  => 'nullable|string|max:100',
            'details'  => 'nullable|string|max:5000',
            'doc'      => 'nullable|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:10240',
        ]);

        // Generate unique Request ID
        $requestId = Inquiry::generateRequestId($validated['vertical']);

        // Handle file upload
        $docPath = null;
        if ($request->hasFile('doc')) {
            $docPath = $request->file('doc')->store("inquiries/{$requestId}", 'local');
        }

        // Create inquiry
        $inquiry = Inquiry::create([
            'request_id'  => $requestId,
            'vertical'    => $validated['vertical'],
            'name'        => $validated['name'],
            'company'     => $validated['company'] ?? null,
            'position'    => $validated['position'] ?? null,
            'email'       => $validated['email'],
            'phone'       => $validated['phone'] ?? null,
            'country'     => $validated['country'] ?? null,
            'details'     => $validated['details'] ?? null,
            'doc_path'    => $docPath,
            'status'      => 'new',
        ]);

        // Send email notification (if SMTP configured)
        $this->sendNotification($inquiry);

        return response()->json([
            'success'    => true,
            'request_id' => $requestId,
            'message'    => 'Requirement submitted successfully.',
        ]);
    }

    private function sendNotification(Inquiry $inquiry): void
    {
        $smtp = CmsSetting::getGroup('smtp');

        // Only send if SMTP is configured
        if (empty($smtp['smtp_host']) || empty($smtp['smtp_username'])) {
            return;
        }

        // Dynamically configure mailer from DB settings
        Config::set('mail.mailers.smtp.host',       $smtp['smtp_host']);
        Config::set('mail.mailers.smtp.port',        $smtp['smtp_port'] ?? 587);
        Config::set('mail.mailers.smtp.username',    $smtp['smtp_username']);
        Config::set('mail.mailers.smtp.password',    $smtp['smtp_password']);
        Config::set('mail.mailers.smtp.encryption',  $smtp['smtp_encryption'] ?? 'tls');
        Config::set('mail.from.address',             $smtp['smtp_from_email'] ?? 'noreply@mhtradecap.com');
        Config::set('mail.from.name',                $smtp['smtp_from_name'] ?? 'MH Trade Capital');
        Config::set('mail.default', 'smtp');

        $adminEmail = CmsSetting::get('admin_email', 'contact@mhtradecap.com');

        try {
            Mail::to($adminEmail)->send(new NewInquiryMail($inquiry));
        } catch (\Exception $e) {
            // Silently fail — do not block user submission on mail error
            \Log::error('Mail send failed: ' . $e->getMessage());
        }
    }
}
