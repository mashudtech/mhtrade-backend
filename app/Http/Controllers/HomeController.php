<?php

namespace App\Http\Controllers;

use App\Models\CmsSetting;
use App\Models\Solution;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $solutions    = Solution::published()->get();
        $testimonials = Testimonial::published()->get();
        $contact      = CmsSetting::getGroup('contact');

        return view('pages.home', compact('solutions', 'testimonials', 'contact'));
    }
}
