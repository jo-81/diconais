<?php

namespace App\Tests\Controller\Admin;

use App\Entity\Key;
use App\Entity\User;
use App\Tests\Traits\EntityFinderTrait;
use App\Controller\Admin\KeyCrudController;
use App\Controller\Admin\DashboardController;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use EasyCorp\Bundle\EasyAdminBundle\Test\AbstractCrudTestCase;

class KeyCrudControllerTest extends AbstractCrudTestCase
{
    /**
     * @use EntityFinderTrait<Key>
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
     * testKeyPageWhenUserNotLogged.
     */
    public function testKeyPageWhenUserNotLogged(): void
    {
        $this->client->request('GET', $this->generateIndexUrl());
        static::assertResponseRedirects('/connexion');

        $this->client->request('GET', $this->generateNewFormUrl());
        static::assertResponseRedirects('/connexion');

        $this->client->request('GET', $this->generateEditFormUrl(1));
        static::assertResponseRedirects('/connexion');

        $this->client->request('POST', $this->getCrudUrl('delete', 1));
        static::assertResponseRedirects('/connexion');
    }

    /**
     * testKeyPageWhenUserLogged.
     */
    public function testKeyPageWhenUserLogged(): void
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        $testUser = $userRepository->findOneByEmail('admin@domaine.fr');
        $this->client->loginUser($testUser);

        $this->client->request('GET', $this->generateIndexUrl());
        static::assertResponseIsSuccessful();

        $this->client->request('GET', $this->generateNewFormUrl());
        static::assertResponseStatusCodeSame(403);

        $this->client->request('GET', $this->generateEditFormUrl(1));
        static::assertResponseStatusCodeSame(403);

        $this->client->request('POST', $this->getCrudUrl('delete', 1));
        static::assertResponseStatusCodeSame(403);
    }
}
