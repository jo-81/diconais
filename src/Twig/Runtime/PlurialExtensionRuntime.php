<?php

namespace App\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

class PlurialExtensionRuntime implements RuntimeExtensionInterface
{
    public function doPlurial(string $plurialText, string $singleText, int $count): string
    {
        return $count >= 2 ? $plurialText : $singleText;
    }
}
