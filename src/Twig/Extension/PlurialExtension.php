<?php

namespace App\Twig\Extension;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use App\Twig\Runtime\PlurialExtensionRuntime;

class PlurialExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('plurial', [PlurialExtensionRuntime::class, 'doPlurial']),
        ];
    }
}
