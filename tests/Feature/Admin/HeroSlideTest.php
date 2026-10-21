<?php

namespace Tests\Feature\Admin;

use App\Models\HeroSlide;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class HeroSlideTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config(['app.url' => 'http://localhost']);
        URL::forceRootUrl('http://localhost');
    }

    public function test_public_homepage_renders_hero_slides(): void
    {
        $slide1 = HeroSlide::create([
            'tag' => 'Structured Trade Finance',
            'title' => 'Global Capital Solutions &',
            'title_accent' => 'Banking Facilities',
            'subtitle' => 'Connecting international buyers and sellers with structured liquidity.',
            'button_text' => 'Submit Requirement',
            'button_vertical' => 'general',
            'background_image' => 'images/hero/dubai_hero_bg_2k.webp',
            'order_index' => 1,
            'is_active' => true,
        ]);

        $slide2 = HeroSlide::create([
            'tag' => 'Corporate Banking',
            'title' => 'UAE Business Setup &',
            'title_accent' => 'Corporate Banking',
            'subtitle' => 'Streamlined corporate bank account opening across Dubai top-tier banks.',
            'button_text' => 'Get Started',
            'button_vertical' => 'uae-banking',
            'background_image' => 'images/hero/dubai_hero_bg.webp',
            'order_index' => 2,
            'is_active' => true,
        ]);

        $response = $this->get(route('home'));
        $response->assertOk()
            ->assertSee('hero-slider-container')
            ->assertSee('hero-slider-prev')
            ->assertSee('hero-slider-next')
            ->assertSee('hero-slider-dots')
            ->assertSee('Global Capital Solutions &')
            ->assertSee('UAE Business Setup &');
    }

    public function test_guest_cannot_access_hero_slide_admin(): void
    {
        $response = $this->get(route('admin.slides.index'));
        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_view_slides_list_and_create_page(): void
    {
        $this->actingAs(User::factory()->create());

        HeroSlide::create([
            'title' => 'Test Slide Listing',
            'order_index' => 1,
            'is_active' => true,
        ]);

        $response = $this->get(route('admin.slides.index'));
        $response->assertOk()
            ->assertSee('Hero Slider Management')
            ->assertSee('Test Slide Listing');

        $createResponse = $this->get(route('admin.slides.create'));
        $createResponse->assertOk()
            ->assertSee('Add New Hero Slide');
    }

    public function test_admin_can_store_new_hero_slide(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->post(route('admin.slides.store'), [
            'tag' => 'Energy & Commodity Sourcing',
            'title' => 'International Commodity Facilitation &',
            'title_accent' => 'Trade Execution',
            'subtitle' => 'Qualified suppliers of energy, metals, and agricultural goods.',
            'button_text' => 'Contact Commodities Team',
            'button_vertical' => 'commodity',
            'order_index' => 3,
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.slides.index'));

        $this->assertDatabaseHas('hero_slides', [
            'tag' => 'Energy & Commodity Sourcing',
            'title' => 'International Commodity Facilitation &',
            'title_accent' => 'Trade Execution',
            'button_vertical' => 'commodity',
            'order_index' => 3,
            'is_active' => 1,
        ]);
    }

    public function test_admin_can_update_hero_slide(): void
    {
        $this->actingAs(User::factory()->create());

        $slide = HeroSlide::create([
            'title' => 'Original Title',
            'order_index' => 1,
            'is_active' => true,
        ]);

        $response = $this->put(route('admin.slides.update', $slide), [
            'title' => 'Updated Title',
            'title_accent' => 'New Accent',
            'subtitle' => 'Updated subtitle text.',
            'button_text' => 'Apply Now',
            'button_vertical' => 'lc',
            'order_index' => 5,
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.slides.index'));

        $this->assertDatabaseHas('hero_slides', [
            'id' => $slide->id,
            'title' => 'Updated Title',
            'title_accent' => 'New Accent',
            'order_index' => 5,
        ]);
    }

    public function test_admin_can_delete_hero_slide(): void
    {
        $this->actingAs(User::factory()->create());

        $slide = HeroSlide::create([
            'title' => 'Slide To Delete',
            'order_index' => 10,
            'is_active' => true,
        ]);

        $response = $this->delete(route('admin.slides.destroy', $slide));
        $response->assertRedirect(route('admin.slides.index'));

        $this->assertDatabaseMissing('hero_slides', [
            'id' => $slide->id,
        ]);
    }
}
