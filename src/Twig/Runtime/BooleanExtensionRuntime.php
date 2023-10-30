<?php

namespace App\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

class BooleanExtensionRuntime implements RuntimeExtensionInterface
{
    public function doPublished(bool $published): string
    {
        $label = $published ? 'OUI' : 'NON';
        $class_bg = $published ? 'bg-success' : 'bg-danger';

        return '<span class="px-2 py-1 '.$class_bg.' rounded-2"><small class="fw-bold text-white">'.$label.'</small></span>';
    }
}
