<?php

namespace Database\Seeders;

use App\Models\HeroSlide;
use Illuminate\Database\Seeder;

class HeroSlideSeeder extends Seeder
{
    public function run(): void
    {
        HeroSlide::updateOrCreate(
            ['order_index' => 1],
            [
                'tag' => 'Trade Finance • Banking Instruments • Project Finance • Commodity Trade',
                'title' => 'Structured Trade Finance &',
                'title_accent' => 'Capital Solutions',
                'subtitle' => "Connecting Real Transactions with the Right Financial Solutions\nDubai-Based | 40+ Banking Relationships Worldwide | 11+ Years of Experience",
                'button_text' => 'Submit Requirement',
                'button_link' => null,
                'button_vertical' => 'general',
                'background_image' => 'images/hero/dubai_hero_bg_2k.webp',
                'is_active' => true,
            ]
        );

        HeroSlide::updateOrCreate(
            ['order_index' => 2],
            [
                'tag' => 'Global Logistics • Maritime Sourcing • Bulk Commodities',
                'title' => 'International Maritime Trade &',
                'title_accent' => 'Supply Chain Finance',
                'subtitle' => "Facilitating Global Cargo Movements with Confirmed Letters of Credit & Proof of Funds\nDirect Transaction Structuring Across Asia, Africa, Europe and the Middle East",
                'button_text' => 'Explore Trade Facilities',
                'button_link' => null,
                'button_vertical' => 'lc',
                'background_image' => 'images/hero/maritime_trade_port.webp',
                'is_active' => true,
            ]
        );

        HeroSlide::updateOrCreate(
            ['order_index' => 3],
            [
                'tag' => 'Project Finance • Capital Syndication • Financial Instruments',
                'title' => 'Connecting Real Transactions with',
                'title_accent' => 'Global Capital Solutions',
                'subtitle' => "Unlocking Liquidity & Trade Capabilities with 40+ Tier-1 Banking Relationships\nSBLCs, Bank Guarantees & Non-Recourse Project Funding for Enterprise Growth",
                'button_text' => 'Request Consultation',
                'button_link' => null,
                'button_vertical' => 'bg_sblc',
                'background_image' => 'images/hero/global_corporate_banking.webp',
                'is_active' => true,
            ]
        );

        HeroSlide::updateOrCreate(
            ['order_index' => 4],
            [
                'tag' => 'UAE Corporate Setup • Strategic Advisory • Offshore Banking',
                'title' => 'Strategic UAE Expansion &',
                'title_accent' => 'Institutional Banking Setup',
                'subtitle' => "Seamless Free Zone & Mainland Incorporation Coupled with Premium Corporate Accounts\nTrusted by Multinational Corporations, Family Offices and Global Trading Houses",
                'button_text' => 'Get Started in Dubai',
                'button_link' => null,
                'button_vertical' => 'corporate_setup',
                'background_image' => 'images/hero/dubai_marina_capital.webp',
                'is_active' => true,
            ]
        );
    }
}
