<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

afterEach(function () {
    File::deleteDirectory(base_path('src/Domain'));
});

it('creates a ddd action in the domain layer', function () {
    $this->artisan('ddd:action', ['domain' => 'Posts', 'name' => 'CreatePost'])->assertSuccessful();

    $path = base_path('src/Domain/Posts/Actions/CreatePost.php');

    expect(File::exists($path))->toBeTrue();

    expect(File::get($path))
        ->toContain('namespace Domain\Posts\Actions;')
        ->toContain('final readonly class CreatePost');
});
