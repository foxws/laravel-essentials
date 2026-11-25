<?php

declare(strict_types=1);

namespace Foxws\Essentials\Csp\Presets;

use Spatie\Csp\Directive;
use Spatie\Csp\Policy;
use Spatie\Csp\Preset;

/**
 * Allows icons to be fetched from the Iconify API, as @iconify/vue and Nuxt UI do,
 * including the host they fall back to when the first one fails.
 */
class IconifyPreset implements Preset
{
    public function configure(Policy $policy): void
    {
        $policy->add(Directive::CONNECT, ['api.iconify.design', 'api2.iconify.design']);
    }
}
