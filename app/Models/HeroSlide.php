<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    use HasFactory;

    protected $fillable = [
        'tag',
        'title',
        'title_accent',
        'subtitle',
        'button_text',
        'button_link',
        'button_vertical',
        'background_image',
        'order_index',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order_index' => 'integer',
    ];

    public function getImageUrlAttribute(): string
    {
        if (empty($this->background_image)) {
            return asset('images/hero/dubai_hero_bg_2k.webp');
        }

        if (str_starts_with($this->background_image, 'http://') || str_starts_with($this->background_image, 'https://')) {
            return $this->background_image;
        }

        if (str_starts_with($this->background_image, 'images/') || str_starts_with($this->background_image, 'uploads/')) {
            return asset($this->background_image);
        }

        if (file_exists(public_path('uploads/slides/'.$this->background_image))) {
            return asset('uploads/slides/'.$this->background_image);
        }

        return asset($this->background_image);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('order_index');
    }
}
