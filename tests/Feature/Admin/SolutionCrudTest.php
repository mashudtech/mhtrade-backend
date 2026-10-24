<?php

namespace Tests\Feature\Admin;

use App\Models\Solution;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class SolutionCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config(['app.url' => 'http://localhost']);
        URL::forceRootUrl('http://localhost');
    }

    public function test_admin_can_view_solution_create_page(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->get(route('admin.solutions.create'));
        $response->assertOk()
            ->assertSee('Create New Solution')
            ->assertSee('solution-item-template');
    }

    public function test_admin_can_store_new_solution_with_simplified_items(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->post(route('admin.solutions.store'), [
            'title' => 'Warehouse Logistics & Financing',
            'badge' => 'Warehouse, Inventory, Collateral',
            'inquiry_prefix' => 'MH-WARE',
            'inquiry_start_number' => 8000,
            'short_desc' => 'Financing solutions backed by warehouse collateral and verified logistics.',
            'overview' => 'Detailed framework for warehouse goods inspection and financing.',
            'items' => [
                [
                    'title' => 'Collateral Assessment',
                    'desc' => 'Physical inspection and valuation of warehouse goods.',
                ],
                [
                    'title' => 'Inventory Line of Credit',
                    'desc' => 'Revolving credit facility against stored inventory.',
                ],
            ],
        ]);

        $response->assertRedirect(route('admin.solutions.index'));

        $this->assertDatabaseHas('solutions', [
            'title' => 'Warehouse Logistics & Financing',
            'slug' => 'warehouse-logistics-financing',
            'badge' => 'Warehouse, Inventory, Collateral',
            'inquiry_prefix' => 'MH-WARE',
            'inquiry_start_number' => 8000,
        ]);

        $solution = Solution::where('slug', 'warehouse-logistics-financing')->firstOrFail();
        $this->assertSame(2, $solution->items()->count());

        $this->assertDatabaseHas('solution_items', [
            'solution_id' => $solution->id,
            'title' => 'Collateral Assessment',
            'desc' => 'Physical inspection and valuation of warehouse goods.',
            'sort_order' => 1,
        ]);
    }

    public function test_admin_can_delete_solution_and_its_items_are_cascaded(): void
    {
        $this->actingAs(User::factory()->create());

        $solution = Solution::create([
            'slug' => 'disposable-solution',
            'num' => '99',
            'title' => 'Disposable Solution',
            'hero_headline' => 'Disposable Solution',
            'badge' => 'Test',
            'short_desc' => 'To be deleted',
            'overview' => 'Overview to be deleted',
        ]);

        $item1 = $solution->items()->create([
            'num' => '01',
            'title' => 'Item 1',
            'desc' => 'Item 1 desc',
            'sort_order' => 1,
        ]);

        $item2 = $solution->items()->create([
            'num' => '02',
            'title' => 'Item 2',
            'desc' => 'Item 2 desc',
            'sort_order' => 2,
        ]);

        $this->assertDatabaseHas('solutions', ['id' => $solution->id]);
        $this->assertDatabaseHas('solution_items', ['id' => $item1->id]);
        $this->assertDatabaseHas('solution_items', ['id' => $item2->id]);

        $response = $this->delete(route('admin.solutions.destroy', $solution));
        $response->assertRedirect(route('admin.solutions.index'));

        $this->assertDatabaseMissing('solutions', ['id' => $solution->id]);
        $this->assertDatabaseMissing('solution_items', ['id' => $item1->id]);
        $this->assertDatabaseMissing('solution_items', ['id' => $item2->id]);
    }
}
