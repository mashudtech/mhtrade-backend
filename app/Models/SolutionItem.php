<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SolutionItem extends Model
{
    protected $fillable = [
        'solution_id', 'num', 'title', 'subtitle', 'desc', 'details', 'summary', 'sort_order',
    ];

    public function solution(): BelongsTo
    {
        return $this->belongsTo(Solution::class);
    }
}
