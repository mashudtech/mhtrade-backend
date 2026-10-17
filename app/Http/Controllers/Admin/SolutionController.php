<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Solution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SolutionController extends Controller
{
    public function index()
    {
        $solutions = Solution::orderBy('sort_order')->get();

        return view('admin.solutions.index', compact('solutions'));
    }

    public function edit(Solution $solution)
    {
        $solution->load('items');

        return view('admin.solutions.edit', compact('solution'));
    }

    public function update(Request $request, Solution $solution)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'hero_headline' => 'nullable|string|max:500',
            'hero_headline_accent' => 'nullable|string|max:500',
            'badge' => 'required|string|max:500',
            'short_desc' => 'required|string',
            'overview' => 'required|string',
            'process_text' => 'nullable|string',
            'highlight_banner' => 'nullable|string|max:500',
            'image_file' => 'nullable|file|image|mimes:jpeg,png,jpg,webp,svg|max:10240',
            'items_form_submitted' => 'required|accepted',
            'items' => 'sometimes|array|max:65535',
            'items.*.id' => [
                'nullable',
                'integer',
                'distinct',
                Rule::exists('solution_items', 'id')->where('solution_id', $solution->id),
            ],
            'items.*.title' => 'required|string|max:255',
            'items.*.subtitle' => 'required|string|max:255',
            'items.*.desc' => 'required|string',
            'items.*.details' => 'nullable|string',
            'items.*.summary' => 'required|string',
        ]);

        $headline = trim($validated['hero_headline'] ?? '');
        $accent = trim($validated['hero_headline_accent'] ?? '');

        if ($accent !== '') {
            $formattedHeadline = $headline.'<br><span style="color: var(--gold-primary);">'.$accent.'</span>';
        } else {
            $formattedHeadline = $headline;
        }

        $updateData = [
            'title' => $validated['title'],
            'hero_headline' => $formattedHeadline,
            'badge' => $validated['badge'],
            'short_desc' => $validated['short_desc'],
            'overview' => $validated['overview'],
            'process_text' => $validated['process_text'] ?? null,
            'highlight_banner' => $validated['highlight_banner'] ?? null,
        ];

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = 'solution_'.$solution->slug.'_'.time().'.'.$file->getClientOriginalExtension();
            $dest = public_path('images/uploads');
            if (! file_exists($dest)) {
                mkdir($dest, 0755, true);
            }
            $file->move($dest, $filename);
            $updateData['image'] = 'images/uploads/'.$filename;
        }

        DB::transaction(function () use ($solution, $updateData, $validated) {
            $solution->update($updateData);

            $items = array_values($validated['items'] ?? []);
            $submittedItemIds = collect($items)
                ->pluck('id')
                ->filter()
                ->map(fn ($id) => (int) $id)
                ->all();

            $itemsToDelete = $solution->items();
            if ($submittedItemIds !== []) {
                $itemsToDelete->whereNotIn('id', $submittedItemIds);
            }
            $itemsToDelete->delete();

            foreach ($items as $index => $itemData) {
                $itemAttributes = [
                    'num' => str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT),
                    'title' => $itemData['title'],
                    'subtitle' => $itemData['subtitle'],
                    'desc' => $itemData['desc'],
                    'details' => $itemData['details'] ?? '',
                    'summary' => $itemData['summary'],
                    'sort_order' => $index + 1,
                ];

                if (! empty($itemData['id'])) {
                    $solution->items()->whereKey($itemData['id'])->firstOrFail()->update($itemAttributes);
                } else {
                    $solution->items()->create($itemAttributes);
                }
            }
        });

        return back()->with('success', "Solution '{$solution->title}' updated successfully.");
    }

    public function toggle(Solution $solution)
    {
        $solution->update(['is_published' => ! $solution->is_published]);
        $status = $solution->is_published ? 'published' : 'unpublished';

        return back()->with('success', "Solution {$status} successfully.");
    }
}
