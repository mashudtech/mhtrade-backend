<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class HeroSlideController extends Controller
{
    public function index(): View
    {
        $slides = HeroSlide::orderBy('order_index')->get();

        return view('admin.slides.index', compact('slides'));
    }

    public function create(): View
    {
        $nextOrder = (HeroSlide::max('order_index') ?? 0) + 1;

        return view('admin.slides.create', compact('nextOrder'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tag' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'title_accent' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:500',
            'button_vertical' => 'nullable|string|max:100',
            'image_file' => 'nullable|file|image|mimes:jpeg,png,jpg,webp,svg|max:15360',
            'order_index' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $imagePath = 'images/hero/dubai_hero_bg_2k.webp';
        if ($request->hasFile('image_file')) {
            $destinationPath = public_path('uploads/slides');
            if (! file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $fileName = 'slide_'.time().'_'.Str::random(6).'.'.$request->file('image_file')->getClientOriginalExtension();
            $request->file('image_file')->move($destinationPath, $fileName);
            $imagePath = 'uploads/slides/'.$fileName;
        }

        $orderIndex = isset($validated['order_index']) && $validated['order_index'] !== ''
            ? (int) $validated['order_index']
            : ((HeroSlide::max('order_index') ?? 0) + 1);

        HeroSlide::create([
            'tag' => $validated['tag'] ?? null,
            'title' => $validated['title'],
            'title_accent' => $validated['title_accent'] ?? null,
            'subtitle' => $validated['subtitle'] ?? null,
            'button_text' => $validated['button_text'] ?: 'Submit Requirement',
            'button_link' => $validated['button_link'] ?? null,
            'button_vertical' => $validated['button_vertical'] ?: 'general',
            'background_image' => $imagePath,
            'order_index' => $orderIndex,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.slides.index')->with('success', 'Slide created successfully.');
    }

    public function edit(HeroSlide $slide): View
    {
        return view('admin.slides.edit', compact('slide'));
    }

    public function update(Request $request, HeroSlide $slide): RedirectResponse
    {
        $validated = $request->validate([
            'tag' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'title_accent' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:500',
            'button_vertical' => 'nullable|string|max:100',
            'image_file' => 'nullable|file|image|mimes:jpeg,png,jpg,webp,svg|max:15360',
            'order_index' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image_file')) {
            $destinationPath = public_path('uploads/slides');
            if (! file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // Remove previous uploaded image if stored in uploads/slides/
            if (! empty($slide->background_image) && str_starts_with($slide->background_image, 'uploads/slides/')) {
                $oldFile = public_path($slide->background_image);
                if (file_exists($oldFile)) {
                    @unlink($oldFile);
                }
            }

            $fileName = 'slide_'.time().'_'.Str::random(6).'.'.$request->file('image_file')->getClientOriginalExtension();
            $request->file('image_file')->move($destinationPath, $fileName);
            $slide->background_image = 'uploads/slides/'.$fileName;
        }

        $slide->tag = $validated['tag'] ?? null;
        $slide->title = $validated['title'];
        $slide->title_accent = $validated['title_accent'] ?? null;
        $slide->subtitle = $validated['subtitle'] ?? null;
        $slide->button_text = $validated['button_text'] ?: 'Submit Requirement';
        $slide->button_link = $validated['button_link'] ?? null;
        $slide->button_vertical = $validated['button_vertical'] ?: 'general';
        if (isset($validated['order_index'])) {
            $slide->order_index = (int) $validated['order_index'];
        }
        $slide->is_active = $request->boolean('is_active');

        $slide->save();

        return redirect()->route('admin.slides.index')->with('success', 'Slide updated successfully.');
    }

    public function destroy(HeroSlide $slide): RedirectResponse
    {
        if (! empty($slide->background_image) && str_starts_with($slide->background_image, 'uploads/slides/')) {
            $file = public_path($slide->background_image);
            if (file_exists($file)) {
                @unlink($file);
            }
        }

        $slide->delete();

        return redirect()->route('admin.slides.index')->with('success', 'Slide deleted successfully.');
    }
}
