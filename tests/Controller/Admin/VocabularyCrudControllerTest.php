<?php

namespace App\Tests\Controller\Admin;

use App\Entity\User;
use App\Controller\Admin\DashboardController;
use App\Controller\Admin\VocabularyCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Test\AbstractCrudTestCase;

class VocabularyCrudControllerTest extends AbstractCrudTestCase
{
    protected function getControllerFqcn(): string
    {
        return VocabularyCrudController::class;
    }

    protected function getDashboardFqcn(): string
    {
        return DashboardController::class;
    }

    /**
     * testVocabularyPageWhenUserNotLogged.
     */
    public function testVocabularyPageWhenUserNotLogged(): void
    {
        $this->client->request('GET', $this->generateIndexUrl());
        static::assertResponseRedirects('/connexion');

        $this->client->request('GET', $this->generateDetailUrl(1));
        static::assertResponseRedirects('/connexion');
    }

    /**
     * testVocabularyPageWhenUserLogged.
     */
    public function testVocabularyPageWhenUserLogged(): void
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
