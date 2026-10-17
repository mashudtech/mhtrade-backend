<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $fillable = [
        'request_id', 'vertical', 'name', 'company', 'position',
        'email', 'phone', 'country', 'details', 'doc_path', 'status', 'internal_notes',
    ];

    /**
     * Vertical prefix map for generating Request IDs.
     */
    public static array $prefixMap = [
        'lc'          => 'MH-LC',
        'uae-banking' => 'MH-BANK',
        'project'     => 'MH-PROJ',
        'commodity'   => 'MH-COM',
        'general'     => 'MH-REQ',
    ];

    /**
     * Generate the next sequential Request ID for a given vertical.
     */
    public static function generateRequestId(string $vertical): string
    {
        $prefix = self::$prefixMap[$vertical] ?? 'MH-REQ';

        $last = self::where('request_id', 'like', $prefix . '-%')
            ->orderByDesc('id')
            ->value('request_id');

        $nextNum = 1;
        if ($last) {
            $parts   = explode('-', $last);
            $nextNum = (int) end($parts) + 1;
        }

        return $prefix . '-' . str_pad($nextNum, 5, '0', STR_PAD_LEFT);
    }

    /**
     * Human-readable status labels.
     */
    public static array $statusLabels = [
        'new'                  => 'New',
        'in_review'            => 'In Review',
        'information_required' => 'Information Required',
        'processing'           => 'Processing',
        'completed'            => 'Completed',
        'closed'               => 'Closed',
    ];

    public function getStatusLabelAttribute(): string
    {
        return self::$statusLabels[$this->status] ?? ucfirst($this->status);
    }

    public function getVerticalLabelAttribute(): string
    {
        $labels = [
            'lc'          => 'Trade Finance & Banking Instruments',
            'uae-banking' => 'UAE Business & Corporate Banking',
            'project'     => 'Project Finance',
            'commodity'   => 'Commodity Trade Solutions',
            'general'     => 'General Business Inquiry',
        ];
        return $labels[$this->vertical] ?? ucfirst($this->vertical);
    }
}
