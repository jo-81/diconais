<?php

namespace App\Tests\Controller\Admin;

use App\Entity\User;
use App\Entity\Kanji;
use App\Tests\Traits\EntityFinderTrait;
use App\Controller\Admin\DashboardController;
use App\Controller\Admin\KanjiCrudController;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use EasyCorp\Bundle\EasyAdminBundle\Test\AbstractCrudTestCase;

class KanjiCrudControllerTest extends AbstractCrudTestCase
{
    /**
     * @use EntityFinderTrait<Kanji>
     */
    use EntityFinderTrait;
    use ReloadDatabaseTrait;

    protected function getControllerFqcn(): string
    {
        return KanjiCrudController::class;
    }

    protected function getDashboardFqcn(): string
    {
        return DashboardController::class;
    }

    /**
     * testKanjiPageWhenUserNotLogged.
     */
    public function testKanjiPageWhenUserNotLogged(): void
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
     * testKanjiPageWhenUserLogged.
     */
    public function testKanjiPageWhenUserLogged(): void
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        $testUser = $userRepository->findOneByEmail('admin@domaine.fr');
        $this->client->loginUser($testUser);

        $this->client->request('GET', $this->generateIndexUrl());
        static::assertResponseIsSuccessful();
    }
}
