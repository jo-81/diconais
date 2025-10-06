<?php

namespace App\Tests\Controller\Admin;

use App\Entity\Kana;
use App\Entity\User;
use App\Tests\Traits\AssertTrait;
use App\Tests\Traits\EntityFinderTrait;
use App\Controller\Admin\KanaCrudController;
use App\Controller\Admin\DashboardController;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use EasyCorp\Bundle\EasyAdminBundle\Test\AbstractCrudTestCase;

class KanaCrudControllerTest extends AbstractCrudTestCase
{
    /**
     * @use EntityFinderTrait<Kana>
     */
    use EntityFinderTrait;
    use ReloadDatabaseTrait;
    use AssertTrait;

    protected function getControllerFqcn(): string
    {
        return KanaCrudController::class;
    }

    protected function getDashboardFqcn(): string
    {
        return DashboardController::class;
    }

    /**
     * testKanaPageWhenUserNotLogged.
     */
    public function testKanaPageWhenUserNotLogged(): void
    {
        $this->client->request('GET', $this->generateNewFormUrl());
        static::assertResponseRedirects('/connexion');

        $this->client->request('GET', $this->generateDetailUrl(1));
        static::assertResponseRedirects('/connexion');

        $this->client->request('GET', $this->generateIndexUrl());
        static::assertResponseRedirects('/connexion');
    }

    /**
     * testKanaPageWhenUserLogged.
     */
    public function testKanaPageWhenUserLogged(): void
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        $testUser = $userRepository->findOneByEmail('admin@domaine.fr');
        $this->client->loginUser($testUser);

        $this->client->request('GET', $this->generateNewFormUrl());
        static::assertResponseIsSuccessful();

        $this->client->request('GET', $this->generateDetailUrl(1));
        static::assertResponseIsSuccessful();

        $this->client->request('GET', $this->generateIndexUrl());
        static::assertResponseIsSuccessful();
    }

    /**
     * testCreateEntityKana.
     */
    public function testCreateEntityKana(): void
    {
        $testUser = $this->findOneEntityBy(User::class, ['email' => 'admin@domaine.fr']);
        $this->client->loginUser($testUser);
        $crawler = $this->client->request('GET', $this->generateNewFormUrl());

        $form = $crawler->selectButton('Créer')->form();
        $form['Kana[ideogramme]'] = 'や';
        $form['Kana[romaji]'] = 'ya';
        $form['Kana[kunrei]'] = 'ya';
        $form['Kana[accent]'] = '1';
        $form['Kana[combination]'] = '1';
        $form['Kana[position]'] = '10';
        $form['Kana[type]'] = 'hiragana';
        $this->client->submit($form);

        self::assertInstanceOf(Kana::class, $this->findOneEntityBy(Kana::class, ['ideogramme' => 'や']));
        self::assertResponseRedirects();

        $this->client->followRedirect();

        $this->assertSuccessMessageWhenCreateEntity('や');
    }

    public function testUpdateEntityKana(): void
    {
        $testUser = $this->findOneEntityBy(User::class, ['email' => 'admin@domaine.fr']);
        $this->client->loginUser($testUser);
        $crawler = $this->client->request('GET', $this->generateEditFormUrl(1));

        $form = $crawler->selectButton('Sauvegarder les modifications')->form();
        $form['Kana[romaji]'] = 'ki';
        $this->client->submit($form);

        $entityUpdate = $this->findEntity(Kana::class, 1);

        self::assertInstanceOf(Kana::class, $entityUpdate);
        self::assertEquals('ki', $entityUpdate->getRomaji());
        self::assertResponseRedirects();

        $this->client->followRedirect();

        $this->assertSuccessMessageWhenUpdateEntity('あ');
    }
}
