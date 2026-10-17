<?php

namespace App\Http\Controllers;

use App\Models\Solution;

class SolutionController extends Controller
{
    public function index()
    {
        $solutions = Solution::published()->with('items')->get();
        return view('pages.solutions', compact('solutions'));
    }

    public function show(string $slug)
    {
        $solution = Solution::where('slug', $slug)->where('is_published', true)->with('items')->firstOrFail();
        $allSolutions = Solution::published()->get();
        return view('pages.solution-detail', compact('solution', 'allSolutions'));
    }
}
