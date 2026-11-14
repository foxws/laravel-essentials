<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Workbench\App\Models\Post;

beforeEach(function () {
    Schema::create('posts', function (Blueprint $table) {
        $table->id();
        $table->ulid('ulid')->unique();
        $table->ulid('public_id')->nullable()->unique();
        $table->string('title');
        $table->timestamps();
    });
});

it('keeps the incrementing key and fills the ulid column', function () {
    $post = Post::create(['title' => 'Hello']);

    expect($post->getKey())->toBe(1)
        ->and(Str::isUlid($post->ulid))->toBeTrue()
        ->and($post->getRouteKeyName())->toBe('ulid')
        ->and($post->getRouteKey())->toBe($post->ulid);
});

it('finds a model from its ulid', function () {
    $post = Post::create(['title' => 'Hello']);

    expect(Post::findFromUlid($post->ulid)?->is($post))->toBeTrue()
        ->and(Post::findFromUlid($post))->toBe($post)
        ->and(Post::findFromUlid((string) Str::ulid()))->toBeNull();
});

it('calls the callback when no model has the ulid', function () {
    $post = Post::create(['title' => 'Hello']);

    expect(Post::findFromUlidOr($post->ulid, fn () => 'missing')?->is($post))->toBeTrue()
        ->and(Post::findFromUlidOr((string) Str::ulid(), fn () => 'missing'))->toBe('missing');
});

it('throws when no model has the ulid', function () {
    $post = Post::create(['title' => 'Hello']);

    expect(Post::findFromUlidOrFail($post->ulid)->is($post))->toBeTrue();

    Post::findFromUlidOrFail((string) Str::ulid());
})->throws(ModelNotFoundException::class);

it('finds a model in another column', function () {
    $publicId = (string) Str::ulid();
    $post = Post::create(['title' => 'Hello', 'public_id' => $publicId]);

    expect(Post::findFromUlid($publicId))->toBeNull()
        ->and(Post::findFromUlid($publicId, 'public_id')?->is($post))->toBeTrue()
        ->and(Post::findFromUlidOrFail($publicId, 'public_id')->is($post))->toBeTrue()
        ->and(Post::findFromUlidOr($post->ulid, fn () => 'missing', 'public_id'))->toBe('missing');
});

it('finds nothing for an invalid ulid without querying', function () {
    Post::create(['title' => 'Hello']);

    DB::enableQueryLog();

    expect(Post::findFromUlid('not-a-ulid'))->toBeNull()
        ->and(Post::findFromUlidOr('not-a-ulid', fn () => 'missing'))->toBe('missing')
        ->and(DB::getQueryLog())->toBeEmpty();
});

it('throws for an invalid ulid', function () {
    Post::findFromUlidOrFail('not-a-ulid');
})->throws(ModelNotFoundException::class);

it('constrains a query to the given ulids', function () {
    $first = Post::create(['title' => 'First']);
    $second = Post::create(['title' => 'Second']);
    Post::create(['title' => 'Third']);

    expect(Post::whereUlid($first->ulid)->sole()->is($first))->toBeTrue()
        ->and(Post::where('title', 'Second')->whereUlid($first->ulid)->first())->toBeNull()
        ->and(Post::whereUlid([$first->ulid, $second->ulid, 'not-a-ulid'])->pluck('title')->sort()->values()->all())
        ->toBe(['First', 'Second'])
        ->and(Post::whereUlid('not-a-ulid')->exists())->toBeFalse();
});

it('constrains a query on another column', function () {
    $publicId = (string) Str::ulid();
    $post = Post::create(['title' => 'Hello', 'public_id' => $publicId]);

    expect(Post::whereUlid($publicId)->exists())->toBeFalse()
        ->and(Post::whereUlid($publicId, 'public_id')->firstOrFail()->is($post))->toBeTrue();
});
