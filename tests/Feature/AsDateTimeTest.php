<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use Foxws\Essentials\Casts\AsDateTime;
use Illuminate\Database\Eloquent\Model;

beforeEach(function () {
    $this->model = new class extends Model {};
    $this->cast = new AsDateTime;
});

it('stores dates in the app timezone', function () {
    config(['app.timezone' => 'Europe/Amsterdam']);

    expect($this->cast->set($this->model, 'published_at', '2026-01-01 12:00:00+00:00', []))
        ->toBe('2026-01-01 13:00:00');
});

it('reads dates from the date factory', function () {
    expect($this->cast->get($this->model, 'published_at', '2026-01-01 12:00:00', []))
        ->toBeInstanceOf(CarbonImmutable::class);
});

it('treats blank values as null', function (mixed $value) {
    expect($this->cast->get($this->model, 'published_at', $value, []))->toBeNull()
        ->and($this->cast->set($this->model, 'published_at', $value, []))->toBeNull();
})->with([null, '']);
