<?php

namespace Tests\Feature\Admin;

use App\Models\Solution;
use App\Models\SolutionItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class UpdateSolutionItemsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config(['app.url' => 'http://localhost']);
        URL::forceRootUrl('http://localhost');
    }

    public function test_admin_can_add_edit_remove_and_reorder_solution_items(): void
    {
        $this->actingAs(User::factory()->create());

        $solution = $this->createSolution();
        $firstItem = $this->createItem($solution, 'First item', 1);
        $secondItem = $this->createItem($solution, 'Second item', 2);

        $this->put(route('admin.solutions.update', $solution), [
            ...$this->solutionFields(),
            'items' => [
                [
                    'id' => $secondItem->id,
                    'title' => 'Updated second item',
                    'subtitle' => 'Updated subtitle',
                    'desc' => 'Updated description',
                    'details' => '',
                    'summary' => 'Updated summary',
                ],
                [
                    'title' => 'New item',
                    'subtitle' => 'New subtitle',
                    'desc' => 'New description',
                    'details' => 'New details',
                    'summary' => 'New summary',
                ],
            ],
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('solution_items', ['id' => $firstItem->id]);
        $this->assertDatabaseCount('solution_items', 2);

        $savedItems = $solution->items()->get();
        $this->assertSame(['Updated second item', 'New item'], $savedItems->pluck('title')->all());
        $this->assertSame([1, 2], $savedItems->pluck('sort_order')->all());
        $this->assertSame(['01', '02'], $savedItems->pluck('num')->all());
        $this->assertSame('', $savedItems->first()->details);
    }

    public function test_admin_cannot_submit_an_item_from_another_solution(): void
    {
        $this->actingAs(User::factory()->create());

        $solution = $this->createSolution();
        $otherSolution = $this->createSolution('another-solution');
        $foreignItem = $this->createItem($otherSolution, 'Protected item', 1);

        $this->put(route('admin.solutions.update', $solution), [
            ...$this->solutionFields(),
            'items' => [
                [
                    'id' => $foreignItem->id,
                    'title' => 'Tampered item',
                    'subtitle' => 'Tampered subtitle',
                    'desc' => 'Tampered description',
                    'details' => '',
                    'summary' => 'Tampered summary',
                ],
            ],
        ])->assertSessionHasErrors(['items.0.id']);

        $this->assertSame('Protected item', $foreignItem->fresh()->title);
        $this->assertSame(0, $solution->items()->count());
    }

    public function test_admin_can_remove_all_solution_items(): void
    {
        $this->actingAs(User::factory()->create());

        $solution = $this->createSolution();
        $item = $this->createItem($solution, 'Item to remove', 1);

        $this->put(route('admin.solutions.update', $solution), $this->solutionFields())
            ->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('solution_items', ['id' => $item->id]);
    }

    public function test_solution_item_editor_renders_existing_items_and_controls(): void
    {
        $this->actingAs(User::factory()->create());

        $solution = $this->createSolution();
        $this->createItem($solution, 'Visible item', 1);

        $this->get(route('admin.solutions.edit', $solution))
            ->assertOk()
            ->assertSee('Add Item')
            ->assertSee('Visible item')
            ->assertSee('solution-item-template');
    }

    private function createSolution(string $slug = 'test-solution'): Solution
    {
        return Solution::create([
            'slug' => $slug,
            'num' => '01',
            'title' => 'Test solution',
            'hero_headline' => 'Test headline',
            'badge' => 'Test badge',
            'short_desc' => 'Test short description',
            'overview' => 'Test overview',
            'image' => 'test.webp',
        ]);
    }

    private function createItem(Solution $solution, string $title, int $sortOrder): SolutionItem
    {
        return $solution->items()->create([
            'num' => str_pad((string) $sortOrder, 2, '0', STR_PAD_LEFT),
            'title' => $title,
            'subtitle' => 'Test subtitle',
            'desc' => 'Test description',
            'details' => 'Test details',
            'summary' => 'Test summary',
            'sort_order' => $sortOrder,
        ]);
    }

    private function solutionFields(): array
    {
        return [
            'title' => 'Test solution',
            'hero_headline' => 'Test headline',
            'hero_headline_accent' => '',
            'badge' => 'Test badge',
            'short_desc' => 'Test short description',
            'overview' => 'Test overview',
            'process_text' => '',
            'highlight_banner' => '',
            'items_form_submitted' => '1',
        ];
    }
}
