<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent()]
final class ButtonComponent
{
    public string $color = 'primary';
    public string $type = 'button';
    public string $label;
}
