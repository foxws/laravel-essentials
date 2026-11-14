<?php

declare(strict_types=1);

namespace Workbench\App\Models;

use Foxws\Essentials\Concerns\HasUlidRouteKey;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasUlidRouteKey;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'title',
    ];
}
