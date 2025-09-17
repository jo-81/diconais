<?php

namespace App\Tests\Controller\Admin;

use App\Entity\User;
use App\Entity\Theme;
use App\Tests\Traits\EntityFinderTrait;
use App\Controller\Admin\KeyCrudController;
use App\Controller\Admin\DashboardController;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use EasyCorp\Bundle\EasyAdminBundle\Test\AbstractCrudTestCase;

class ThemeCrudControllerTest extends AbstractCrudTestCase
{
    /**
     * @use EntityFinderTrait<Theme>
     */
    use EntityFinderTrait;
    use ReloadDatabaseTrait;

    protected function getControllerFqcn(): string
    {
        return KeyCrudController::class;
    }

    protected function getDashboardFqcn(): string
    {
        return DashboardController::class;
    }

    /**
     * testThemePageWhenUserNotLogged.
     */
    public function testThemePageWhenUserNotLogged(): void
    {
        $this->client->request('GET', $this->generateIndexUrl());
        static::assertResponseRedirects('/connexion');

        $this->client->request('GET', $this->generateDetailUrl(1));
        static::assertResponseRedirects('/connexion');
    }

    /**
     * testThemePageWhenUserLogged.
     */
    public function testThemePageWhenUserLogged(): void
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        $testUser = $userRepository->findOneByEmail('admin@domaine.fr');
        $this->client->loginUser($testUser);

        $this->client->request('GET', $this->generateIndexUrl());
        static::assertResponseIsSuccessful();

        $this->client->request('GET', $this->generateDetailUrl(1));
        static::assertResponseIsSuccessful();
    }
}
