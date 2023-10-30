<?php

namespace App\Enum;

enum SocialIconEnum: string
{
    case Facebook = 'fa-brands fa-facebook fa-lg';
    case Youtube = 'fa-brands fa-youtube fa-lg';
    case Instagram = 'fa-brands fa-instagram fa-lg';
    case Twitch = 'fa-brands fa-twitch fa-lg';
    case Twitter = 'fa-brands fa-x-twitter fa-lg';
    case Website = 'fa-solid fa-globe fa-lg';

    public static function get(?string $icon): self|null
    {
        foreach (self::cases() as $case) {
            if ($case->name == $icon) {
                return $case;
            }
        }

        return null;
    }

    public static function getIcon(string $socialName): ?string
    {
        foreach (self::cases() as $case) {
            if ($case->name == $socialName) {
                return $case->value;
            }
        }

        return null;
    }
}
