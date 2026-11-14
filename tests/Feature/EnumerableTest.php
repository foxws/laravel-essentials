<?php

declare(strict_types=1);

use Workbench\App\Enums\PostStatus;

it('labels a case', function () {
    expect(PostStatus::Published)->toBeInstanceOf(BackedEnum::class)
        ->and(PostStatus::Published->label())->toBe('Published');
});

it('builds the labels of every case, keyed by value', function () {
    expect(PostStatus::labels())->toBe([
        'draft' => 'Draft',
        'published' => 'Published',
    ]);
});
