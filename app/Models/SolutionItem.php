<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SolutionItem extends Model
{
    protected $fillable = [
        'solution_id', 'num', 'title', 'subtitle', 'desc', 'image', 'details', 'summary', 'sort_order',
    ];

    public function solution(): BelongsTo
    {
        return $this->belongsTo(Solution::class);
    }

    public function getImageUrlAttribute(): string
    {
        if (empty($this->image)) {
            if ($this->relationLoaded('solution') && $this->solution) {
                return $this->solution->image_url;
            }

            return asset('images/hero/dubai_hero_bg.webp');
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        if (str_starts_with($this->image, 'images/')) {
            return asset($this->image);
        }

        return asset('images/uploads/'.$this->image);
    }
}
