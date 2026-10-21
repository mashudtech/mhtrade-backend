<?php

namespace Database\Factories;

use App\Models\HeroSlide;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<HeroSlide>
 */
class HeroSlideFactory extends Factory
{
    protected $model = HeroSlide::class;

    public function definition(): array
    {
        return [
            'tag' => 'Trade Finance • Capital Solutions',
            'title' => fake()->sentence(4),
            'title_accent' => 'Capital Solutions',
            'subtitle' => fake()->paragraph(),
            'button_text' => 'Submit Requirement',
            'button_link' => null,
            'button_vertical' => 'general',
            'background_image' => 'images/hero/dubai_hero_bg_2k.webp',
            'order_index' => 1,
            'is_active' => true,
        ];
    }
}
