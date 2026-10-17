<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageContentController extends Controller
{
    /**
     * Display the About Us page content editor.
     */
    public function about()
    {
        $settings = CmsSetting::where('group', 'about')->pluck('value', 'key')->toArray();
        return view('admin.pages.about', compact('settings'));
    }

    /**
     * Update the About Us page content.
     */
    public function updateAbout(Request $request)
    {
        $request->validate([
            'about_image_file' => 'nullable|file|image|mimes:jpeg,png,jpg,webp,svg|max:10240',
        ]);

        // Handle uploaded About Us image
        if ($request->hasFile('about_image_file')) {
            $file = $request->file('about_image_file');
            $filename = 'about_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $dest = public_path('images/uploads');
            if (!file_exists($dest)) {
                mkdir($dest, 0755, true);
            }
            $file->move($dest, $filename);
            CmsSetting::set('about_image', 'images/uploads/' . $filename, 'about', 'Corporate Office Image');
        }

        foreach ($request->input('settings', []) as $key => $value) {
            CmsSetting::set($key, $value, 'about');
        }

        return back()->with('success', 'About Us page content updated successfully.');
    }

    /**
     * Display the Why MH page content editor.
     */
    public function whyMh()
    {
        $settings = CmsSetting::where('group', 'why_mh')->pluck('value', 'key')->toArray();
        return view('admin.pages.why-mh', compact('settings'));
    }

    /**
     * Update the Why MH page content.
     */
    public function updateWhyMh(Request $request)
    {
        $request->validate([
            'why_image_file' => 'nullable|file|image|mimes:jpeg,png,jpg,webp,svg|max:10240',
        ]);

        if ($request->hasFile('why_image_file')) {
            $file = $request->file('why_image_file');
            $filename = 'why_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $dest = public_path('images/uploads');
            if (!file_exists($dest)) {
                mkdir($dest, 0755, true);
            }
            $file->move($dest, $filename);
            CmsSetting::set('why_image', 'images/uploads/' . $filename, 'why_mh', 'Why MH Banner Image');
        }

        foreach ($request->input('settings', []) as $key => $value) {
            CmsSetting::set($key, $value, 'why_mh');
        }

        return back()->with('success', 'Why MH page content updated successfully.');
    }
}
