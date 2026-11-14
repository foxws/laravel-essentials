<?php

declare(strict_types=1);

use Illuminate\Support\Str;

if (! function_exists('markdown')) {
    /**
     * Render Markdown to HTML, stripping raw HTML and unsafe links.
     */
    function markdown(?string $value = null): string
    {
        if (blank($value)) {
            return '';
        }

        return Str::markdown($value, [
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);
    }
}
