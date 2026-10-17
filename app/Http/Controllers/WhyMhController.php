<?php

namespace App\Http\Controllers;

use App\Models\CmsSetting;

class WhyMhController extends Controller
{
    public function index()
    {
        $content = CmsSetting::getGroup('why_mh');

        return view('pages.why-mh', compact('content'));
    }
}
