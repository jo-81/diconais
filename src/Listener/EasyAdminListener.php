<?php

namespace App\Listener;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Translation\TranslatableMessage;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityDeletedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;

final class EasyAdminListener implements EventSubscriberInterface
{
    public function __construct(private RequestStack $requestStack)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            AfterEntityPersistedEvent::class => ['flashMessageAfterPersist'],
            AfterEntityUpdatedEvent::class => ['flashMessageAfterUpdate'],
            AfterEntityDeletedEvent::class => ['flashMessageAfterDelete'],
        ];
    }

    public function flashMessageAfterPersist(AfterEntityPersistedEvent $event): void
    {
        $session = $this->requestStack->getSession();
        if ($session instanceof Session) {
            $session->getFlashBag()->add('success', new TranslatableMessage('content_admin.flash_message.create', [
                '%name%' => (string) $event->getEntityInstance(),
            ], 'admin'));
        }
    }

    public function flashMessageAfterUpdate(AfterEntityUpdatedEvent $event): void
    {
        $session = $this->requestStack->getSession();
        if ($session instanceof Session) {
            $session->getFlashBag()->add('success', new TranslatableMessage('content_admin.flash_message.update', [
                '%name%' => (string) $event->getEntityInstance(),
            ], 'admin'));
        }
    }

    public function flashMessageAfterDelete(AfterEntityDeletedEvent $event): void
    {
        $session = $this->requestStack->getSession();
        if ($session instanceof Session) {
            $session->getFlashBag()->add('success', new TranslatableMessage('content_admin.flash_message.delete', [
                '%name%' => (string) $event->getEntityInstance(),
            ], 'admin'));
        }
    }
}
