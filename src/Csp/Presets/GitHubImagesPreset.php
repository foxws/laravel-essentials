<?php

declare(strict_types=1);

namespace Foxws\Essentials\Csp\Presets;

use Spatie\Csp\Directive;
use Spatie\Csp\Policy;
use Spatie\Csp\Preset;

/**
 * Allows images from raw.githubusercontent.com, such as the ones a README or
 * docs folder synced from GitHub links to.
 */
class GitHubImagesPreset implements Preset
{
    public function configure(Policy $policy): void
    {
        $policy->add(Directive::IMG, 'https://raw.githubusercontent.com');
    }
}
