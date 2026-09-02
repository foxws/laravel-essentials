<?php

declare(strict_types=1);

namespace Foxws\Essentials\Support;

use Illuminate\Support\Facades\Config;

class DomainSubstitutions
{
    /**
     * Get the domain substitutions for the application.
     *
     * @return array<string, string>
     */
    public static function get(): array
    {
        return [
            'action' => 'Actions',
            'cast' => 'Casts',
            'channel' => 'Channels',
            'class' => '',
            'collection' => 'Collections',
            'command' => 'Commands',
            'controller' => 'Controllers',
            'data_transfer_object' => 'Data',
            'dto' => 'Dto',
            'enum' => 'Enums',
            'event' => 'Events',
            'exception' => 'Exceptions',
            'factory' => 'Database\Factories',
            'interface' => '',
            'job' => 'Jobs',
            'listener' => 'Listeners',
            'mail' => 'Mail',
            'middleware' => 'Middleware',
            'migration' => 'Database\Migrations',
            'model' => 'Models',
            'notification' => 'Notifications',
            'observer' => 'Observers',
            'policy' => 'Policies',
            'provider' => 'Providers',
            'query_builder' => 'QueryBuilders',
            'request' => 'Requests',
            'resource' => 'Resources',
            'rule' => 'Rules',
            'scope' => 'Scopes',
            'seeder' => 'Database\Seeders',
            'service' => 'Services',
            'trait' => '',
            'value_object' => 'ValueObjects',
            'view_model' => 'ViewModels',
            ...static::customSubstitutions(),
        ];
    }

    /**
     * Get the custom domain substitutions for the application.
     *
     * @return array<string, string>
     */
    public static function customSubstitutions(): array
    {
        return Config::array('essentials.domain_substitutions', []);
    }
}
