<?php

namespace App\Twig\Runtime;

use App\Entity\ResourceSocial;
use Twig\Extension\RuntimeExtensionInterface;

class SocialLinkExtensionRuntime implements RuntimeExtensionInterface
{
    public function doSocialLink(ResourceSocial $social): string
    {
        return '<p>
            <a target="_blank" href="'.$social->getLink().'">
                <i class="'.$social->getIcon().'"></i>
                <span class="mx-2">'.$social->getIcon('name').'</span>
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
            </a>
        </p>';
    }
}
