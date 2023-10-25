<?php

namespace App\DataFixtures\Providers;

use App\Enum\SocialIconEnum;

class SocialIconEnumProvider
{
    public function getIconSocial(string $icon): SocialIconEnum|null
    {
        return SocialIconEnum::get($icon);
    }
}
