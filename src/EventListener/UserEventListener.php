<?php

namespace App\EventListener;

use Doctrine\ORM\Events;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\PostUpdateEventArgs;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;

#[AsDoctrineListener(event: Events::preUpdate)]
class UserEventListener
{
    public function __construct(private RequestStack $requestStack)
    {
    }

    public function preUpdate(PreUpdateEventArgs $args): void
    {
        /** @var Request */
        $request = $this->requestStack->getCurrentRequest();
        if ($request instanceof Request) {
            $request->getSession()->getFlashBag()->add('success', 'Votre profil a bien été modifié'); /* @phpstan-ignore-line */
        }
    }
}
