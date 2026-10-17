<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total'      => Inquiry::count(),
            'new'        => Inquiry::where('status', 'new')->count(),
            'processing' => Inquiry::whereIn('status', ['in_review', 'processing'])->count(),
            'completed'  => Inquiry::where('status', 'completed')->count(),
        ];

        $byVertical = Inquiry::selectRaw('vertical, count(*) as total')
            ->groupBy('vertical')
            ->pluck('total', 'vertical')
            ->toArray();

        $recent = Inquiry::latest()->take(10)->get();

        return view('admin.dashboard', compact('stats', 'byVertical', 'recent'));
    }
}
