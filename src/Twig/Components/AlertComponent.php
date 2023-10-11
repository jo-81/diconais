<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent()]
final class AlertComponent
{
    public string $color = 'success';
    public string $message = '';
    public bool $dismiss = false;
}
