<?php

namespace App\Twig\Components\Kana;

use App\Entity\Kana;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class KanaCard
{
    public Kana $kana;
}
