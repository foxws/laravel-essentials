<?php

declare(strict_types=1);

namespace Foxws\Essentials\Csp\Presets;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Uri;
use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;
use Spatie\Csp\Policy;
use Spatie\Csp\Preset;
use Spatie\Csp\Scheme;
use Spatie\Csp\Value;

/**
 * A strict policy for apps served with Vite: same-origin sources, the app's subdomains,
 * nonce-based scripts with strict-dynamic, and no framing or plugins.
 */
class BasicPreset implements Preset
{
    public function configure(Policy $policy): void
    {
        $host = $this->host();

        $policy
            ->add(Directive::UPGRADE_INSECURE_REQUESTS, Value::NO_VALUE)
            ->add(Directive::BASE, Keyword::SELF)
            ->add(Directive::CONNECT, Keyword::SELF)
            ->add(Directive::CONNECT, Scheme::BLOB)
            ->add(Directive::DEFAULT, Keyword::SELF)
            ->add(Directive::FONT, Keyword::SELF)
            ->add(Directive::FORM_ACTION, Keyword::SELF)
            ->add(Directive::FRAME, Keyword::SELF)
            ->add(Directive::FRAME_ANCESTORS, Keyword::NONE)
            ->add(Directive::IMG, Keyword::SELF)
            ->add(Directive::IMG, Scheme::DATA)
            ->add(Directive::MEDIA, Keyword::SELF)
            ->add(Directive::MEDIA, Scheme::BLOB)
            ->add(Directive::OBJECT, Keyword::NONE)
            ->add(Directive::SCRIPT, Keyword::STRICT_DYNAMIC)
            ->add(Directive::STYLE, Keyword::SELF)
            ->add(Directive::STYLE, Keyword::UNSAFE_INLINE)
            ->addNonce(Directive::SCRIPT);

        if ($host !== null) {
            $policy
                ->add(Directive::CONNECT, ["https://*.{$host}", "wss://*.{$host}"])
                ->add([Directive::FRAME, Directive::FONT, Directive::STYLE, Directive::IMG], "*.{$host}");
        }
    }

    protected function host(): ?string
    {
        return Uri::of(Config::string('app.url', 'http://localhost'))->host();
    }
}
