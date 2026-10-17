<?php

namespace App\Http\Controllers;

use App\Models\CmsSetting;

class AboutController extends Controller
{
    public function index()
    {
        $contact = CmsSetting::getGroup('contact');
        $content = CmsSetting::getGroup('about');

        return view('pages.about', compact('contact', 'content'));
    }
}
