<?php

namespace App\Twig\Components\Kanji;

use App\Entity\Ideogramme;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class KanjiCard
{
    public Ideogramme $ideogramme;
}
