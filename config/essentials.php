<?php

declare(strict_types=1);

use Foxws\Essentials\Configurables\AggressivePrefetching;
use Foxws\Essentials\Configurables\AutomaticallyEagerLoadRelationships;
use Foxws\Essentials\Configurables\EnforceMorphMap;
use Foxws\Essentials\Configurables\FakeSleep;
use Foxws\Essentials\Configurables\ForceHttpsScheme;
use Foxws\Essentials\Configurables\ForceSecurePassword;
use Foxws\Essentials\Configurables\ImmutableDates;
use Foxws\Essentials\Configurables\ModelShouldBeStrict;
use Foxws\Essentials\Configurables\PreventStrayRequests;
use Foxws\Essentials\Configurables\ProhibitDestructiveCommands;
use Foxws\Essentials\Configurables\ResourceWithoutWrapping;

return [

    /*
    |--------------------------------------------------------------------------
    | Configurable Features
    |--------------------------------------------------------------------------
    |
    | This array contains a list of configurable features that can be enabled
    | or disabled in your application.
    | Each feature is represented by a class that implements the Configurable interface.
    | You can add or remove features from this array as needed.
    |
    */

    'configurables' => env('ESSENTIALS_CONFIGURABLES', [
        AggressivePrefetching::class,
        AutomaticallyEagerLoadRelationships::class,
        EnforceMorphMap::class,
        FakeSleep::class,
        ForceHttpsScheme::class,
        ForceSecurePassword::class,
        ImmutableDates::class,
        ModelShouldBeStrict::class,
        PreventStrayRequests::class,
        ProhibitDestructiveCommands::class,
        ResourceWithoutWrapping::class,
    ]),

    /*
    |--------------------------------------------------------------------------
    | Model Morph Map
    |--------------------------------------------------------------------------
    |
    | This array defines the morph map for your Eloquent models.
    | The morph map allows you to customize the names used for polymorphic relationships.
    |
    */

    'morph_map' => env('ESSENTIALS_MORPH_MAP', [
        // 'user' => Domain\Users\Models\User::class,
        // 'post' => Domain\Posts\Models\Post::class,
    ]),

    /*
    |--------------------------------------------------------------------------
    | Domain Driven Design (DDD) Configuration
    |--------------------------------------------------------------------------
    |
    | You can add any additional configuration options for your application here.
    |
    */

    'ddd_enabled' => env('ESSENTIALS_DDD', true),

    'ddd_substitutions' => env('ESSENTIALS_DDD_SUBSTITUTIONS', [
        // 'action' => 'CustomActions',
    ]),

    /*
    |--------------------------------------------------------------------------
    | Layers
    |--------------------------------------------------------------------------
    |
    | Each layer defines a top-level namespace and the path it maps to. The
    | Domain layer holds framework-agnostic business logic, while Modules
    | holds Laravel-facing code (controllers, requests, middleware) that
    | orchestrates it. Add or remove entries to fit your application's
    | structure; every layer is registered in composer.json by ddd:install.
    |
    */

    'layers' => [

        'Domain' => [
            'namespace' => env('ESSENTIALS_DOMAIN_NAMESPACE', 'Domain'),
            'path' => env('ESSENTIALS_DOMAIN_PATH', 'app/Domain'),
        ],

        'Modules' => [
            'namespace' => env('ESSENTIALS_MODULES_NAMESPACE', 'Modules'),
            'path' => env('ESSENTIALS_MODULES_PATH', 'app/Modules'),
        ],

        'Foundation' => [
            'namespace' => env('ESSENTIALS_FOUNDATION_NAMESPACE', 'Foundation'),
            'path' => env('ESSENTIALS_FOUNDATION_PATH', 'app/Foundation'),
        ],

        'Infrastructure' => [
            'namespace' => env('ESSENTIALS_INFRASTRUCTURE_NAMESPACE', 'Infrastructure'),
            'path' => env('ESSENTIALS_INFRASTRUCTURE_PATH', 'app/Infrastructure'),
        ],

        'Integrations' => [
            'namespace' => env('ESSENTIALS_INTEGRATIONS_NAMESPACE', 'Integrations'),
            'path' => env('ESSENTIALS_INTEGRATIONS_PATH', 'app/Integrations'),
        ],

        'Support' => [
            'namespace' => env('ESSENTIALS_SUPPORT_NAMESPACE', 'Support'),
            'path' => env('ESSENTIALS_SUPPORT_PATH', 'app/Support'),
        ],

    ],

];
