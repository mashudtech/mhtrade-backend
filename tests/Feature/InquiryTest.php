<?php

namespace Tests\Feature;

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
}
