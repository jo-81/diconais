<?php

namespace App\Twig\Extension;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use App\Twig\Runtime\VocabularyReadingRuntime;

class VocabularyReadingExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'reading',
                [VocabularyReadingRuntime::class, 'doReading'],
                ['is_safe' => ['html']]
            ),
        ];
    }
}
