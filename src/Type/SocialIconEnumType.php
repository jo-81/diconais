<?php

namespace App\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class SocialIconEnumType extends Type
{
    public const ENUM_VISIBILITY = 'enumiconsocial';

    public const ICON_FACEBOOK = 'Facebook';
    public const ICON_YOUTUBE = 'Youtube';
    public const ICON_TWITTER = 'Twitter';
    public const ICON_WEBSITE = 'Website';
    public const ICON_TWITCH = 'Twitch';
    public const ICON_INSTAGRAM = 'Instagram';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return "ENUM('Facebook', 'Youtube', 'Twitter', 'Website', 'Twitch', 'Instagram')";
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!in_array($value, [self::ICON_FACEBOOK, self::ICON_YOUTUBE, self::ICON_TWITTER, self::ICON_WEBSITE, self::ICON_TWITCH, self::ICON_INSTAGRAM])) {
            throw new \InvalidArgumentException('Invalid status');
        }

        return $value;
    }

    public function getName()
    {
        return self::ENUM_VISIBILITY;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}
