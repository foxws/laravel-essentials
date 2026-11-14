<?php

declare(strict_types=1);

use Inertia\Support\SessionKey;

it('loads the helpers', function () {
    expect(function_exists('markdown'))->toBeTrue()
        ->and(function_exists('toast'))->toBeTrue();
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

it('flashes a toast to the next inertia response', function () {
    toast('Saved', 'Your changes have been saved.', 'info');

    expect(session()->get(SessionKey::FLASH_DATA))->toMatchArray([
        'title' => 'Saved',
        'description' => 'Your changes have been saved.',
        'type' => 'info',
    ]);
});
