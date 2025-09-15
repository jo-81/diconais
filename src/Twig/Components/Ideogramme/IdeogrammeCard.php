<?php

namespace App\Twig\Components\Ideogramme;

use App\Entity\Ideogramme;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class IdeogrammeCard
{
    public Ideogramme $ideogramme;
}
