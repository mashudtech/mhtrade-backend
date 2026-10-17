<?php

if (!function_exists('format_title')) {
    /**
     * Formats a title for display with optional gold accent text.
     * Works without requiring any HTML tags from non-technical users.
     *
     * @param string|null $title Main title text
     * @param string|null $accent Optional highlight accent text (styled in gold)
     * @param bool $newline Whether the accent appears on a new line (<br>)
     * @return string
     */
    function format_title(?string $title, ?string $accent = null, bool $newline = true): string
    {
        $title = trim($title ?? '');
        $accent = trim($accent ?? '');

        // 1. If explicit accent argument is provided
        if ($accent !== '') {
            $separator = $newline ? '<br>' : ' ';
            return e($title) . $separator . '<span style="color: var(--gold-primary);">' . e($accent) . '</span>';
        }

        if ($title === '') {
            return '';
        }

        // 2. If legacy HTML tag (<span or <br) is present, preserve it
        if (str_contains($title, '<span') || str_contains($title, '<br')) {
            return $title;
        }

        // 3. User typed multi-line title (new line indicates accent on line 2)
        if (str_contains($title, "\n")) {
            $lines = array_values(array_filter(array_map('trim', explode("\n", $title))));
            if (count($lines) >= 2) {
                $main = array_shift($lines);
                $rest = implode(' ', $lines);
                $separator = $newline ? '<br>' : ' ';
                return e($main) . $separator . '<span style="color: var(--gold-primary);">' . e($rest) . '</span>';
            }
        }

        // 4. Bracket syntax: "Main Title [Gold Accent Text]"
        if (preg_match('/^(.*?)\s*\[(.*?)\]\s*$/s', $title, $matches)) {
            $main = trim($matches[1]);
            $acc = trim($matches[2]);
            $separator = $newline ? '<br>' : ' ';
            return e($main) . $separator . '<span style="color: var(--gold-primary);">' . e($acc) . '</span>';
        }

        // 5. Asterisk syntax: "Main Title *Gold Accent Text*"
        if (preg_match('/^(.*?)\s*\*(.*?)\*\s*$/s', $title, $matches)) {
            $main = trim($matches[1]);
            $acc = trim($matches[2]);
            $separator = $newline ? '<br>' : ' ';
            return e($main) . $separator . '<span style="color: var(--gold-primary);">' . e($acc) . '</span>';
        }

        // 6. Plain text
        return e($title);
    }
}

if (!function_exists('content_image_url')) {
    /**
     * Resolves an image path or URL for public rendering with fallback.
     *
     * @param string|null $path Stored path or URL
     * @param string $fallback Fallback relative asset path
     * @return string
     */
    function content_image_url(?string $path, string $fallback = 'images/about_us_dubai.webp'): string
    {
        if (empty($path)) {
            return asset($fallback);
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return asset($path);
    }
}
