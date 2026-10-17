<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('sort_order')->get();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'initials'     => 'required|string|max:5',
            'name'         => 'required|string|max:255',
            'position'     => 'required|string|max:255',
            'company'      => 'required|string|max:255',
            'deal_size'    => 'nullable|string|max:255',
            'badge'        => 'nullable|string|max:255',
            'quote'        => 'required|string',
            'is_published' => 'boolean',
            'sort_order'   => 'integer|min:0',
        ]);

        Testimonial::create($validated);
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial created.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'initials'     => 'required|string|max:5',
            'name'         => 'required|string|max:255',
            'position'     => 'required|string|max:255',
            'company'      => 'required|string|max:255',
            'deal_size'    => 'nullable|string|max:255',
            'badge'        => 'nullable|string|max:255',
            'quote'        => 'required|string',
            'is_published' => 'boolean',
            'sort_order'   => 'integer|min:0',
        ]);

        $testimonial->update($validated);
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return back()->with('success', 'Testimonial deleted.');
    }
}
