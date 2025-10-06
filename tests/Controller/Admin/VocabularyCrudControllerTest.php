<?php

namespace App\Tests\Controller\Admin;

use App\Entity\User;
use App\Entity\Vocabulary;
use App\Tests\Traits\AssertTrait;
use App\Tests\Traits\EntityFinderTrait;
use App\Controller\Admin\DashboardController;
use App\Controller\Admin\VocabularyCrudController;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use EasyCorp\Bundle\EasyAdminBundle\Test\AbstractCrudTestCase;

class VocabularyCrudControllerTest extends AbstractCrudTestCase
{
    /**
     * @use EntityFinderTrait<Vocabulary>
     */
    use EntityFinderTrait;
    use ReloadDatabaseTrait;
    use AssertTrait;

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

        $this->client->request('GET', $this->generateNewFormUrl());
        static::assertResponseRedirects('/connexion');

        $this->client->request('GET', $this->generateEditFormUrl(1));
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

        $this->client->request('GET', $this->generateNewFormUrl());
        static::assertResponseIsSuccessful();

        $this->client->request('GET', $this->generateEditFormUrl(1));
        static::assertResponseIsSuccessful();
    }

    public function testCreateEntityVocabulary(): void
    {
        $testUser = $this->findOneEntityBy(User::class, ['email' => 'admin@domaine.fr']);
        $this->client->loginUser($testUser);
        $crawler = $this->client->request('GET', $this->generateNewFormUrl());

        $form = $crawler->selectButton('Créer')->form();
        $form['Vocabulary[signification]'] = 'vocabulary';
        $form['Vocabulary[reading]'] = 'reading';
        $form['Vocabulary[romaji]'] = 'romaji';
        $this->client->submit($form);

        self::assertInstanceOf(Vocabulary::class, $this->findOneEntityBy(Vocabulary::class, ['signification' => 'vocabulary']));
        self::assertResponseRedirects();

        $this->client->followRedirect();

        $this->assertSuccessMessageWhenCreateEntity('vocabulary');
    }

    public function testUpdateEntityVocabulary(): void
    {
        $testUser = $this->findOneEntityBy(User::class, ['email' => 'admin@domaine.fr']);
        $this->client->loginUser($testUser);
        $crawler = $this->client->request('GET', $this->generateEditFormUrl(1));

        $form = $crawler->selectButton('Sauvegarder les modifications')->form();
        $form['Vocabulary[signification]'] = 'update vocabulary';
        $this->client->submit($form);

        $entityUpdate = $this->findEntity(Vocabulary::class, 1);

        self::assertInstanceOf(Vocabulary::class, $entityUpdate);
        self::assertEquals('update vocabulary', $entityUpdate->getSignification());
        self::assertResponseRedirects();

        $this->client->followRedirect();

        $this->assertSuccessMessageWhenUpdateEntity('update vocabulary');
    }
}
