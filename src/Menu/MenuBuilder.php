<?php

namespace App\Menu;

use App\Entity\Admin;
use Knp\Menu\ItemInterface;
use Knp\Menu\FactoryInterface;
use Knp\Menu\Attribute\AsMenuBuilder;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\User\UserInterface;

class MenuBuilder
{
    public function __construct(
        private FactoryInterface $factory,
        private RequestStack $requestStack,
        private Security $security,
    ) {
    }

    #[AsMenuBuilder(name: 'main')]
    public function createMainMenu(array $options): ItemInterface
    {
        $currentRoute = $this->requestStack->getCurrentRequest()->attributes->get('_route');
        $activeClass = 'fw-bold active';

        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'navbar-nav ms-auto mt-3 mt-lg-0 mb-2 mb-lg-0');

        $menu->addChild('Cours', ['route' => 'course.list'])
            ->setAttributes(['class' => 'nav-item'])
            ->setLinkAttributes(['class' => \str_contains($currentRoute, 'course')  ? $activeClass.' nav-link' : 'fw-bold nav-link'])
        ;

        $menu->addChild('Ideogramme', ['route' => 'ideogramme.list'])
            ->setAttributes(['class' => 'nav-item'])
            ->setLinkAttributes(['class' => \str_contains($currentRoute, 'ideogramme') ? $activeClass.' nav-link' : 'fw-bold nav-link'])
        ;

        if (!$this->security->getUser() instanceof UserInterface) {
            $menu->addChild('Connexion', ['route' => 'app_login'])
                ->setAttributes(['class' => 'nav-item'])
                ->setLinkAttributes(['class' => 'app_login' === $currentRoute ? $activeClass.' nav-link' : 'fw-bold nav-link'])
            ;
        }

        if ($this->security->getUser() instanceof Admin) {
            $menu->addChild('Dashboard', ['route' => 'admin'])
                ->setAttributes(['class' => 'nav-item'])
                ->setLinkAttributes(['class' => 'app_login' === $currentRoute ? $activeClass.' nav-link' : 'fw-bold nav-link'])
            ;
        }

        return $menu;
    }
}
