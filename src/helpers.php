<?php

declare(strict_types=1);

use Illuminate\Support\Str;
use Inertia\Inertia;

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

if (! function_exists('toast') && class_exists(Inertia::class)) {
    /**
     * Flash a toast notification to the next Inertia response.
     */
    function toast(string $title, string $description, string $type = 'success'): void
    {
        Inertia::flash([
            'title' => $title,
            'description' => $description,
            'type' => $type,
        ]);
    }
}
