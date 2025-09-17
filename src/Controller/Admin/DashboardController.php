<?php

namespace App\Controller\Admin;

use App\Entity\Key;
use App\Entity\Kana;
use App\Entity\Kanji;
use App\Entity\Theme;
use App\Entity\Course;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Response;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        return $this->redirect($adminUrlGenerator->setController(CourseCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Diconais');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Cours');
        yield MenuItem::linkToCrud('Cours', 'fa-solid fa-list', Course::class);
        yield MenuItem::linkToCrud('Catégories', 'fa-solid fa-tag', Category::class);

        yield MenuItem::section('Idéogrammes');
        yield MenuItem::linkToCrud('Kanji', 'fa-solid fa-k', Kanji::class);
        yield MenuItem::linkToCrud('Key', 'fa-solid fa-key', Key::class);
        yield MenuItem::linkToCrud('Kana', 'fa-solid fa-language', Kana::class);

        yield MenuItem::section('Vocabulaires');
        yield MenuItem::linkToCrud('Thème', 'fa-solid fa-scroll', Theme::class);
    }
}
