<?php

namespace App\Tests\Controller\Admin;

use App\Entity\User;
use App\Controller\Admin\DashboardController;
use App\Controller\Admin\CategoryCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Test\AbstractCrudTestCase;

final class CategoryCrudControllerTest extends AbstractCrudTestCase
{
    protected function getControllerFqcn(): string
    {
        return CategoryCrudController::class;
    }

    protected function getDashboardFqcn(): string
    {
        return DashboardController::class;
    }

    /**
     * testIndexPageWhenUserNotLogged.
     */
    public function testIndexPageWhenUserNotLogged(): void
    {
        $this->client->request('GET', $this->generateIndexUrl());

        static::assertResponseRedirects('/connexion');
    }

    /**
     * testIndexPageWhenUserLogged.
     */
    public function testIndexPageWhenUserLogged(): void
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        $testUser = $userRepository->findOneByEmail('admin@domaine.fr');
        $this->client->loginUser($testUser);
        $this->client->request('GET', $this->generateIndexUrl());

        static::assertResponseIsSuccessful();
    }
}
