<?php

namespace App\Twig\Runtime;

use App\Entity\ResourceSocial;
use App\Enum\SocialIconEnum;
use Twig\Extension\RuntimeExtensionInterface;

class SocialLinkExtensionRuntime implements RuntimeExtensionInterface
{
    public function doSocialLink(ResourceSocial $social): string
    {
        $icon = $social->getIcon();
        if (null == $icon) {
            return '';
        }

        return '<p>
            <a target="_blank" href="'.$social->getLink().'">
                <i class="'.SocialIconEnum::getIcon($icon).'"></i>
                <span class="mx-2">'.$icon.'</span>
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
            </a>
        </p>';
    }

    public function doSocialIcon(ResourceSocial $social): string
    {
        $icon = $social->getIcon();
        if (null == $icon) {
            return '';
        }

        return '<a class="me-1" target="_blank" href="'.$social->getLink().'">
            <i class="'.SocialIconEnum::getIcon($icon).'"></i>
        </a>';
    }
}
