<?php

namespace App\Http\Controllers;

use App\Models\CmsSetting;
use App\Models\HeroSlide;
use App\Models\Solution;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $heroSlides = HeroSlide::active()->get();
        $solutions = Solution::published()->get();
        $testimonials = Testimonial::published()->get();
        $contact = CmsSetting::getGroup('contact');

        return view('pages.home', compact('heroSlides', 'solutions', 'testimonials', 'contact'));
    }
}
