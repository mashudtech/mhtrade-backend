<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Solution extends Model
{
    protected $fillable = [
        'slug', 'num', 'inquiry_prefix', 'inquiry_start_number', 'title', 'hero_headline', 'badge',
        'short_desc', 'overview', 'image', 'process_text',
        'highlight_banner', 'is_published', 'sort_order',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'inquiry_start_number' => 'integer',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(SolutionItem::class)->orderBy('sort_order');
    }

    public function getImageUrlAttribute(): string
    {
        if (empty($this->image)) {
            return asset('images/hero/dubai_hero_bg.webp');
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        if (str_starts_with($this->image, 'images/')) {
            return asset($this->image);
        }

        return asset('images/verticals/'.$this->image);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('sort_order');
    }

    public function hasMeaningfulContent(string $field): bool
    {
        $value = $this->{$field} ?? null;
        if ($value === null) {
            return false;
        }

        $plain = strip_tags((string) $value, '<img>');
        $plain = html_entity_decode($plain, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $plain = trim(str_replace("\xc2\xa0", ' ', $plain));

        return $plain !== '';
    }

    public function getResolvedPrefixAttribute(): string
    {
        if (! empty($this->inquiry_prefix)) {
            return strtoupper(trim($this->inquiry_prefix));
        }

        $clean = preg_replace('/[^a-zA-Z]/', '', $this->title);
        $short = substr(strtoupper($clean), 0, 4);

        return 'MH-'.($short ?: 'REQ');
    }
}
