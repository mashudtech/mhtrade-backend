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
        'lc' => 'MH-LC',
        'trade-finance' => 'MH-LC',
        'uae-banking' => 'MH-BANK',
        'project' => 'MH-PROJ',
        'project-finance' => 'MH-PROJ',
        'commodity' => 'MH-COM',
        'commodity-trade' => 'MH-COM',
        'general' => 'MH-REQ',
        'general-inquiry' => 'MH-REQ',
    ];

    public static function getPrefixForVertical(string $vertical): string
    {
        $aliasMap = [
            'lc' => 'trade-finance',
            'project' => 'project-finance',
            'commodity' => 'commodity-trade',
            'general' => 'general-inquiry',
        ];
        $lookupSlug = $aliasMap[$vertical] ?? $vertical;
        $solution = Solution::where('slug', $lookupSlug)->orWhere('slug', $vertical)->first();
        if ($solution && ! empty($solution->inquiry_prefix)) {
            return strtoupper(trim($solution->inquiry_prefix));
        }

        if (isset(self::$prefixMap[$vertical])) {
            return self::$prefixMap[$vertical];
        }

        $clean = preg_replace('/[^a-zA-Z0-9]/', '', $vertical);
        $code = strtoupper(substr($clean, 0, 4));

        return 'MH-'.($code ?: 'REQ');
    }

    /**
     * Generate the next sequential Request ID for a given vertical.
     */
    public static function generateRequestId(string $vertical): string
    {
        $aliasMap = [
            'lc' => 'trade-finance',
            'project' => 'project-finance',
            'commodity' => 'commodity-trade',
            'general' => 'general-inquiry',
        ];
        $lookupSlug = $aliasMap[$vertical] ?? $vertical;
        $solution = Solution::where('slug', $lookupSlug)->orWhere('slug', $vertical)->first();

        if ($solution) {
            $prefix = ! empty($solution->inquiry_prefix)
                ? strtoupper(trim($solution->inquiry_prefix))
                : self::getPrefixForVertical($vertical);
            $startOffset = (int) ($solution->inquiry_start_number ?: 1000);
        } else {
            $prefix = self::getPrefixForVertical($vertical);
            $startOffset = 1000;
        }

        if ($startOffset < 1) {
            $startOffset = 1;
        }

        $last = self::where('request_id', 'like', $prefix.'-%')
            ->orderByDesc('id')
            ->value('request_id');

        $nextNum = $startOffset;
        if ($last) {
            $parts = explode('-', $last);
            $lastNum = (int) end($parts);
            $nextNum = max($lastNum + 1, $startOffset);
        }

        // Ensure uniqueness
        do {
            $padding = max(5, strlen((string) $nextNum));
            $candidate = $prefix.'-'.str_pad((string) $nextNum, $padding, '0', STR_PAD_LEFT);
            $exists = self::where('request_id', $candidate)->exists();
            if ($exists) {
                $nextNum++;
            }
        } while ($exists);

        return $candidate;
    }

    /**
     * Human-readable status labels.
     */
    public static array $statusLabels = [
        'new' => 'New',
        'in_review' => 'In Review',
        'information_required' => 'Information Required',
        'processing' => 'Processing',
        'completed' => 'Completed',
        'closed' => 'Closed',
    ];

    public function getStatusLabelAttribute(): string
    {
        return self::$statusLabels[$this->status] ?? ucfirst($this->status);
    }

    public function getVerticalLabelAttribute(): string
    {
        $solution = Solution::where('slug', $this->vertical)->first();
        if ($solution) {
            return $solution->title;
        }

        $labels = [
            'lc' => 'Trade Finance & Banking Instruments',
            'uae-banking' => 'UAE Business Setup & Corporate Banking',
            'project' => 'Project Finance',
            'commodity' => 'Commodity Trade Solutions',
            'general' => 'General Business Inquiry',
        ];

        return $labels[$this->vertical] ?? ucwords(str_replace(['-', '_'], ' ', $this->vertical));
    }
}
