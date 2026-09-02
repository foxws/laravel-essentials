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
    | Each layer maps a namespace to a path. ddd:install registers these in
    | composer.json. Change "namespace" to nest a layer under App\ instead,
    | e.g. App\Modules, if you prefer.
    |
    */

    'layers' => [

        'Domain' => [
            'namespace' => env('ESSENTIALS_DOMAIN_NAMESPACE', 'Domain'),
            'path' => env('ESSENTIALS_DOMAIN_PATH', 'src/Domain'),
        ],

        'Modules' => [
            'namespace' => env('ESSENTIALS_MODULES_NAMESPACE', 'Modules'),
            'path' => env('ESSENTIALS_MODULES_PATH', 'src/Modules'),
        ],

        'Foundation' => [
            'namespace' => env('ESSENTIALS_FOUNDATION_NAMESPACE', 'Foundation'),
            'path' => env('ESSENTIALS_FOUNDATION_PATH', 'src/Foundation'),
        ],

        'Infrastructure' => [
            'namespace' => env('ESSENTIALS_INFRASTRUCTURE_NAMESPACE', 'Infrastructure'),
            'path' => env('ESSENTIALS_INFRASTRUCTURE_PATH', 'src/Infrastructure'),
        ],

        'Integrations' => [
            'namespace' => env('ESSENTIALS_INTEGRATIONS_NAMESPACE', 'Integrations'),
            'path' => env('ESSENTIALS_INTEGRATIONS_PATH', 'src/Integrations'),
        ],

        'Support' => [
            'namespace' => env('ESSENTIALS_SUPPORT_NAMESPACE', 'Support'),
            'path' => env('ESSENTIALS_SUPPORT_PATH', 'src/Support'),
        ],

    ],

];
