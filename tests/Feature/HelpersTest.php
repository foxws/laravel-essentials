<?php

declare(strict_types=1);

it('loads the helpers', function () {
    expect(function_exists('markdown'))->toBeTrue();
});

it('renders markdown without raw html', function () {
    expect(markdown('**bold** <script>alert(1)</script>'))
        ->toContain('<strong>bold</strong>')
        ->not->toContain('<script>');
});

it('renders blank markdown as an empty string', function () {
    expect(markdown(null))->toBe('')
        ->and(markdown(''))->toBe('');
});
