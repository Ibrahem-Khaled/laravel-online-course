<?php

if (!function_exists('formatTextWithLinks')) {
    function formatTextWithLinks($text, $limit = 30)
    {
        return preg_replace_callback(
            '~(http[s]?:\/\/[^\s]+)~i',
            function ($matches) use ($limit) {
                $url = $matches[1];
                $displayUrl = Str::limit($url, $limit, '...'); // اختصار الرابط
                return '<a href="' . e($url) . '" target="_blank" style="color: #ed6b2f; text-decoration: underline;">' . e($displayUrl) . '</a>';
            },
            e($text) // لضمان سلامة النص
        );
    }
}