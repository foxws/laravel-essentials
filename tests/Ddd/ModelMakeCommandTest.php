<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

afterEach(function () {
    File::deleteDirectory(base_path('src/Domain'));
});

it('creates a ddd model in the domain layer', function () {
    $this->artisan('ddd:model', ['domain' => 'Posts', 'name' => 'Post'])->assertSuccessful();

    $path = base_path('src/Domain/Posts/Models/Post.php');

    expect(File::exists($path))->toBeTrue();

    expect(File::get($path))
        ->toContain('namespace Domain\Posts\Models;')
        ->toContain('class Post extends Model');
});

it('does not overwrite an existing model without --force', function () {
    $this->artisan('ddd:model', ['domain' => 'Posts', 'name' => 'Post'])->assertSuccessful();

    $this->artisan('ddd:model', ['domain' => 'Posts', 'name' => 'Post'])
        ->expectsOutputToContain('Model already exists.');
});

it('overwrites an existing model with --force', function () {
    $this->artisan('ddd:model', ['domain' => 'Posts', 'name' => 'Post'])->assertSuccessful();

    $this->artisan('ddd:model', ['domain' => 'Posts', 'name' => 'Post', '--force' => true])->assertSuccessful();
});

it('fails when the target layer is disabled', function () {
    config(['essentials.layers.Domain' => null]);

    $this->artisan('ddd:model', ['domain' => 'Posts', 'name' => 'Post'])
        ->expectsOutputToContain('The "Domain" layer is not configured or has been disabled in essentials.layers.')
        ->assertFailed();
});
