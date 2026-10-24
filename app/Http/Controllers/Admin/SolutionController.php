<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Solution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SolutionController extends Controller
{
    public function index()
    {
        $solutions = Solution::withCount('items')->orderBy('sort_order')->get();

        return view('admin.solutions.index', compact('solutions'));
    }

    public function create()
    {
        return view('admin.solutions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:solutions,slug',
            'hero_headline' => 'nullable|string|max:500',
            'hero_headline_accent' => 'nullable|string|max:500',
            'badge' => 'nullable|string|max:500',
            'short_desc' => 'required|string',
            'overview' => 'required|string',
            'process_text' => 'nullable|string',
            'highlight_banner' => 'nullable|string|max:500',
            'image_file' => 'nullable|file|image|mimes:jpeg,png,jpg,webp,svg|max:10240',
            'items_form_submitted' => 'nullable',
            'items' => 'sometimes|array|max:65535',
            'items.*.title' => 'required|string|max:255',
            'items.*.desc' => 'required|string',
            'items.*.image_file' => 'nullable|file|image|mimes:jpeg,png,jpg,webp,svg|max:10240',
        ]);

        $headline = trim($validated['hero_headline'] ?? '');
        $accent = trim($validated['hero_headline_accent'] ?? '');

        if ($accent !== '') {
            $formattedHeadline = $headline.'<br><span style="color: var(--gold-primary);">'.$accent.'</span>';
        } else {
            $formattedHeadline = $headline;
        }

        $slug = ! empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['title']);
        $baseSlug = $slug;
        $counter = 1;
        while (Solution::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        $maxSortOrder = (int) Solution::max('sort_order');
        $sortOrder = $maxSortOrder + 1;
        $num = str_pad((string) $sortOrder, 2, '0', STR_PAD_LEFT);

        $solutionData = [
            'slug' => $slug,
            'num' => $num,
            'title' => $validated['title'],
            'hero_headline' => $formattedHeadline ?: $validated['title'],
            'badge' => $validated['badge'] ?? $validated['title'],
            'short_desc' => $validated['short_desc'],
            'overview' => $this->cleanHtml($validated['overview'] ?? null) ?? '',
            'image' => null,
            'process_text' => $this->cleanHtml($validated['process_text'] ?? null),
            'highlight_banner' => $this->cleanHtml($validated['highlight_banner'] ?? null),
            'is_published' => true,
            'sort_order' => $sortOrder,
        ];

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = 'solution_'.$slug.'_'.time().'.'.$file->getClientOriginalExtension();
            $dest = public_path('images/uploads');
            if (! file_exists($dest)) {
                mkdir($dest, 0755, true);
            }
            $file->move($dest, $filename);
            $solutionData['image'] = 'images/uploads/'.$filename;
        }

        DB::transaction(function () use ($solutionData, $request, $validated) {
            $solution = Solution::create($solutionData);

            $items = array_values($validated['items'] ?? []);
            foreach ($items as $index => $itemData) {
                $itemAttributes = [
                    'num' => str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT),
                    'title' => $itemData['title'],
                    'desc' => $itemData['desc'],
                    'subtitle' => $itemData['subtitle'] ?? '',
                    'details' => $itemData['details'] ?? '',
                    'summary' => $itemData['summary'] ?? '',
                    'sort_order' => $index + 1,
                ];

                if ($request->hasFile("items.{$index}.image_file")) {
                    $itemFile = $request->file("items.{$index}.image_file");
                    $itemFilename = 'item_'.$solution->id.'_'.($index + 1).'_'.time().'.'.$itemFile->getClientOriginalExtension();
                    $dest = public_path('images/uploads/solutions/items');
                    if (! file_exists($dest)) {
                        mkdir($dest, 0755, true);
                    }
                    $itemFile->move($dest, $itemFilename);
                    $itemAttributes['image'] = 'images/uploads/solutions/items/'.$itemFilename;
                }

                $solution->items()->create($itemAttributes);
            }
        });

        return redirect()->route('admin.solutions.index')->with('success', "Solution '{$validated['title']}' created successfully.");
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
            'items.*.subtitle' => 'nullable|string|max:255',
            'items.*.desc' => 'required|string',
            'items.*.details' => 'nullable|string',
            'items.*.summary' => 'nullable|string',
            'items.*.existing_image' => 'nullable|string',
            'items.*.image_file' => 'nullable|file|image|mimes:jpeg,png,jpg,webp,svg|max:10240',
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
            'overview' => $this->cleanHtml($validated['overview'] ?? null) ?? '',
            'process_text' => $this->cleanHtml($validated['process_text'] ?? null),
            'highlight_banner' => $this->cleanHtml($validated['highlight_banner'] ?? null),
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

        DB::transaction(function () use ($solution, $updateData, $validated, $request) {
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
                    'subtitle' => $itemData['subtitle'] ?? '',
                    'desc' => $itemData['desc'],
                    'details' => $itemData['details'] ?? '',
                    'summary' => $itemData['summary'] ?? '',
                    'sort_order' => $index + 1,
                ];

                if ($request->hasFile("items.{$index}.image_file")) {
                    $itemFile = $request->file("items.{$index}.image_file");
                    $itemFilename = 'item_'.$solution->id.'_'.($index + 1).'_'.time().'.'.$itemFile->getClientOriginalExtension();
                    $dest = public_path('images/uploads/solutions/items');
                    if (! file_exists($dest)) {
                        mkdir($dest, 0755, true);
                    }
                    $itemFile->move($dest, $itemFilename);
                    $itemAttributes['image'] = 'images/uploads/solutions/items/'.$itemFilename;
                } elseif (! empty($itemData['existing_image'])) {
                    $itemAttributes['image'] = $itemData['existing_image'];
                }

                if (! empty($itemData['id'])) {
                    $solution->items()->whereKey($itemData['id'])->firstOrFail()->update($itemAttributes);
                } else {
                    $solution->items()->create($itemAttributes);
                }
            }
        });

        return back()->with('success', "Solution '{$solution->title}' updated successfully.");
    }

    public function destroy(Solution $solution)
    {
        $title = $solution->title;

        DB::transaction(function () use ($solution) {
            foreach ($solution->items as $item) {
                if ($item->image && file_exists(public_path($item->image))) {
                    @unlink(public_path($item->image));
                }
            }

            $solution->items()->delete();

            if ($solution->image && str_starts_with($solution->image, 'images/uploads/') && file_exists(public_path($solution->image))) {
                @unlink(public_path($solution->image));
            }

            $solution->delete();
        });

        return redirect()->route('admin.solutions.index')->with('success', "Solution '{$title}' and all its items have been deleted successfully.");
    }

    public function toggle(Solution $solution)
    {
        $solution->update(['is_published' => ! $solution->is_published]);
        $status = $solution->is_published ? 'published' : 'unpublished';

        return back()->with('success', "Solution {$status} successfully.");
    }

    private function cleanHtml(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $plain = strip_tags($value, '<img>');
        $plain = html_entity_decode($plain, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $plain = trim(str_replace("\xc2\xa0", ' ', $plain));

        if ($plain === '') {
            return null;
        }

        return trim($value);
    }
}
