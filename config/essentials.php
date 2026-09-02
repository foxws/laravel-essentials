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

    /*
    |--------------------------------------------------------------------------
    | Domain Namespace and Path
    |--------------------------------------------------------------------------
    |
    | These options define the namespace and path for your domain layer.
    | You can customize these values to fit your application's structure.
    |
    */

    'domain_namespace' => env('ESSENTIALS_DOMAIN_NAMESPACE', 'Domain'),

    'domain_path' => env('ESSENTIALS_DOMAIN_PATH', base_path('src/Domain')),

    'domain_substitutions' => env('ESSENTIALS_DOMAIN_SUBSTITUTIONS', [
        // 'action' => 'CustomActions',
    ]),

    /*
    |--------------------------------------------------------------------------
    | Application Namespace and Path
    |--------------------------------------------------------------------------
    |
    | These options define the namespace and path for your application layer.
    | You can customize these values to fit your application's structure.
    |
    */

    'application_namespace' => env('ESSENTIALS_APP_NAMESPACE', 'App/Modules'),

    'application_path' => env('ESSENTIALS_APP_PATH', base_path('src/App/Modules')),

    /*
    |--------------------------------------------------------------------------
    | Custom Layers
    |--------------------------------------------------------------------------
    |
    | Additional top-level namespaces and paths that should be recognized as
    | layers when generating ddd:* objects.
    |
    */

    'layers' => [
        'Foundation' => env('ESSENTIALS_FOUNDATION_PATH', 'src/Foundation'),
        'Infrastructure' => env('ESSENTIALS_INFRASTRUCTURE_PATH', 'src/Infrastructure'),
        'Integrations' => env('ESSENTIALS_INTEGRATIONS_PATH', 'src/Integrations'),
        'Support' => env('ESSENTIALS_SUPPORT_PATH', 'src/Support'),
    ],

];
