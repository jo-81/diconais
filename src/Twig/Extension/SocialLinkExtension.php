<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\SocialLinkExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class SocialLinkExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
            new TwigFilter('filter_name', [SocialLinkExtensionRuntime::class, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('socialLink', [SocialLinkExtensionRuntime::class, 'doSocialLink'], ['is_safe' => ['html']]),
            new TwigFunction('socialIcon', [SocialLinkExtensionRuntime::class, 'doSocialIcon'], ['is_safe' => ['html']]),
        ];
    }
}
