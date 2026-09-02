<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    $this->composerPath = base_path('composer.json');
    $this->originalComposer = File::get($this->composerPath);
});

afterEach(function () {
    File::put($this->composerPath, $this->originalComposer);

    foreach (['app/Domain', 'app/Modules', 'app/Foundation', 'app/Infrastructure', 'app/Integrations', 'app/Support'] as $path) {
        File::deleteDirectory(base_path($path));
    }
});

it('adds the domain driven design autoload mappings to composer.json', function () {
    $this->artisan('ddd:install', ['--no-dump-autoload' => true])->assertSuccessful();

    $composer = json_decode(File::get($this->composerPath), true);

    expect($composer['autoload']['psr-4'])
        ->toHaveKey('Domain\\', 'app/Domain/')
        ->toHaveKey('Modules\\', 'app/Modules/')
        ->toHaveKey('Foundation\\', 'app/Foundation/')
        ->toHaveKey('Support\\', 'app/Support/');

    expect($composer['autoload']['files'])->toContain('app/Foundation/Helpers.php');
});

it('creates the domain driven design directories and helper file', function () {
    $this->artisan('ddd:install', ['--no-dump-autoload' => true])->assertSuccessful();

    expect(File::isDirectory(base_path('app/Domain')))->toBeTrue();
    expect(File::isDirectory(base_path('app/Modules')))->toBeTrue();
    expect(File::exists(base_path('app/Foundation/Helpers.php')))->toBeTrue();
});

it('is idempotent on a second run', function () {
    $this->artisan('ddd:install', ['--no-dump-autoload' => true])->assertSuccessful();

    $this->artisan('ddd:install', ['--no-dump-autoload' => true])
        ->expectsOutputToContain('composer.json already contains the DDD autoload mappings.')
        ->assertSuccessful();
});

it('warns instead of overwriting a conflicting namespace without --force', function () {
    $composer = json_decode(File::get($this->composerPath), true);
    $composer['autoload']['psr-4']['Domain\\'] = 'somewhere/else/';
    File::put($this->composerPath, json_encode($composer, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

    $this->artisan('ddd:install', ['--no-dump-autoload' => true])
        ->expectsOutputToContain('Skipped "Domain\": already mapped to "somewhere/else/".')
        ->assertSuccessful();

    $composer = json_decode(File::get($this->composerPath), true);

    expect($composer['autoload']['psr-4']['Domain\\'])->toBe('somewhere/else/');
});

it('overwrites a conflicting namespace with --force', function () {
    $composer = json_decode(File::get($this->composerPath), true);
    $composer['autoload']['psr-4']['Domain\\'] = 'somewhere/else/';
    File::put($this->composerPath, json_encode($composer, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

    $this->artisan('ddd:install', ['--force' => true, '--no-dump-autoload' => true])->assertSuccessful();

    $composer = json_decode(File::get($this->composerPath), true);

    expect($composer['autoload']['psr-4']['Domain\\'])->toBe('app/Domain/');
});
