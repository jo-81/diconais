<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent()]
final class InputComponent
{
    public string $type = 'text';
    public string $name;
    public string $id;
    public string $label;
    /** @var array<string> */
    public array $attrs = [];
}
