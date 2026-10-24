<?php

namespace Tests\Feature;

use App\Models\Inquiry;
use App\Models\Solution;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class InquiryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config(['app.url' => 'http://localhost']);
        URL::forceRootUrl('http://localhost');
    }

    public function test_inquiry_requires_company_and_details(): void
    {
        $response = $this->postJson('/inquiry', [
            'vertical' => 'lc',
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            // company and details intentionally omitted
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['company', 'details']);
    }

    public function test_inquiry_succeeds_when_all_mandatory_fields_provided(): void
    {
        $response = $this->postJson('/inquiry', [
            'vertical' => 'lc',
            'name' => 'Jane Doe',
            'company' => 'Acme Global Trade',
            'email' => 'jane@example.com',
            'details' => 'Need 5M USD LC facility for commodity trade.',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $this->assertDatabaseHas('inquiries', [
            'name' => 'Jane Doe',
            'company' => 'Acme Global Trade',
            'email' => 'jane@example.com',
        ]);
    }

    public function test_inquiry_number_respects_per_solution_starting_number_and_prefix(): void
    {
        Solution::create([
            'num' => '01',
            'title' => 'Trade Finance',
            'slug' => 'trade-finance',
            'hero_headline' => 'Headline',
            'badge' => 'LC',
            'short_desc' => 'Short',
            'overview' => 'Overview',
            'image' => 'img.jpg',
            'inquiry_prefix' => 'MH-LC',
            'inquiry_start_number' => 3500,
            'is_published' => true,
        ]);

        $response = $this->postJson('/inquiry', [
            'vertical' => 'trade-finance',
            'name' => 'John Trade',
            'company' => 'Global Imports',
            'email' => 'john@example.com',
            'details' => 'Seeking trade facility.',
        ]);

        $response->assertStatus(200);

        $inquiry = Inquiry::where('email', 'john@example.com')->first();
        $this->assertNotNull($inquiry);
        $this->assertSame('MH-LC-03500', $inquiry->request_id);

        $response2 = $this->postJson('/inquiry', [
            'vertical' => 'trade-finance',
            'name' => 'Jane Trade',
            'company' => 'Global Imports 2',
            'email' => 'jane2@example.com',
            'details' => 'Seeking second trade facility.',
        ]);
        $response2->assertStatus(200);

        $inquiry2 = Inquiry::where('email', 'jane2@example.com')->first();
        $this->assertSame('MH-LC-03501', $inquiry2->request_id);
    }

    public function test_inquiry_accepts_dynamic_solution_slugs(): void
    {
        Solution::create([
            'num' => '06',
            'title' => 'Supply Chain Factoring',
            'slug' => 'supply-chain-factoring',
            'hero_headline' => 'Headline for factoring',
            'badge' => 'Factoring, Supply Chain',
            'short_desc' => 'Short description',
            'overview' => 'Overview content',
            'image' => 'images/sample.jpg',
            'is_published' => true,
        ]);

        $response = $this->postJson('/inquiry', [
            'vertical' => 'supply-chain-factoring',
            'name' => 'Alex Supply',
            'company' => 'Supply Ltd',
            'email' => 'alex@example.com',
            'details' => 'Need factoring line for receivables.',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('inquiries', [
            'email' => 'alex@example.com',
            'vertical' => 'supply-chain-factoring',
        ]);
    }

    public function test_admin_can_export_inquiries_report(): void
    {
        $this->actingAs(User::factory()->create());

        Inquiry::create([
            'request_id' => 'MH-LC-01001',
            'vertical' => 'lc',
            'name' => 'Export Test User',
            'company' => 'Export Co',
            'email' => 'export@example.com',
            'details' => 'Details for export test.',
            'status' => 'new',
        ]);

        $response = $this->get(route('admin.inquiries.export', ['period' => 'all']));

        $response->assertOk();
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $this->assertStringContainsString('attachment; filename="inquiries_report_all_', (string) $response->headers->get('Content-Disposition'));

        $content = $response->streamedContent();
        $this->assertStringContainsString('MH-LC-01001', $content);
        $this->assertStringContainsString('Export Test User', $content);
        $this->assertStringContainsString('Export Co', $content);
    }
}
