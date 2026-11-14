<?php

declare(strict_types=1);

namespace Workbench\App\Models;

use Foxws\Essentials\Concerns\HasUlid;
use Illuminate\Database\Eloquent\Attributes\RouteKey;
use Illuminate\Database\Eloquent\Model;

#[RouteKey('ulid')]
class Post extends Model
{
    use HasUlid;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'public_id',
    ];
}
