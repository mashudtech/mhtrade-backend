<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'initials'     => 'MV',
                'name'         => 'Marcus Vance',
                'position'     => 'Managing Director',
                'company'      => 'Global Energy Logistics Ltd',
                'deal_size'    => '$45,000,000 DLC Instrument',
                'badge'        => 'Verified LC Facility',
                'quote'        => 'MH Trade Capital structured our $45M Letter of Credit facility within 4 banking days when conventional lenders dragged for weeks. Their non-date reference tracking gave us complete confidentiality and flawless counterparty acceptance.',
                'is_published' => true,
                'sort_order'   => 1,
            ],
            [
                'initials'     => 'RA',
                'name'         => 'Sheikh Rashid Al-Maktoum',
                'position'     => 'Chief Procurement Officer',
                'company'      => 'ME Agri Commodities FZCO',
                'deal_size'    => '50,000 MT Bulk Allocation',
                'badge'        => 'Verified Commodity Trade',
                'quote'        => 'Connecting directly with allocation holders through MH Trade Capital eliminated non-performing intermediaries. We secured 50,000 MT of bulk agri commodities with full Proof of Product verification and seamless banking compliance.',
                'is_published' => true,
                'sort_order'   => 2,
            ],
            [
                'initials'     => 'ER',
                'name'         => 'Elena Rostova',
                'position'     => 'VP Infrastructure',
                'company'      => 'EuroAsia Energy Group',
                'deal_size'    => '$120,000,000 Debt Syndication',
                'badge'        => 'Verified Project Funding',
                'quote'        => 'For our renewable energy power expansion, MH Trade Capital facilitated debt structuring and capital syndication seamlessly out of Dubai. Their international banking relationships provided true institutional execution.',
                'is_published' => true,
                'sort_order'   => 3,
            ],
            [
                'initials'     => 'TM',
                'name'         => 'Tariq Mansoor',
                'position'     => 'CEO',
                'company'      => 'Apex Shipping & Trade Holding',
                'deal_size'    => 'Dubai Corporate Banking Setup',
                'badge'        => 'Verified Corporate Setup',
                'quote'        => 'Opening a multi-currency corporate bank account in Dubai used to take months. The advisory team at MH Trade Capital streamlined compliance, documentation, and account setup in just 5 business days!',
                'is_published' => true,
                'sort_order'   => 4,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }

        $this->command->info('✅ Testimonials seeded successfully.');
    }
}
