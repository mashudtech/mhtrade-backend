<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsSetting;
use Illuminate\Http\Request;

class CmsSettingController extends Controller
{
    public function index()
    {
        $contact = CmsSetting::where('group', 'contact')->orderBy('id')->get();
        $social  = CmsSetting::where('group', 'social')->orderBy('id')->get();
        $general = CmsSetting::where('group', 'general')->orderBy('id')->get();
        return view('admin.settings.index', compact('contact', 'social', 'general'));
    }

    public function update(Request $request)
    {
        $settings = $request->input('settings', []);

        if ($request->hasFile('site_logo_file')) {
            $file = $request->file('site_logo_file');
            $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            $dest = public_path('images/uploads');
            if (!file_exists($dest)) {
                mkdir($dest, 0755, true);
            }
            $file->move($dest, $filename);
            CmsSetting::set('site_logo', 'images/uploads/' . $filename, 'general', 'Site Logo');
        }

        foreach ($settings as $key => $value) {
            CmsSetting::set($key, $value);
        }

        return back()->with('success', 'Settings updated successfully.');
    }
}
