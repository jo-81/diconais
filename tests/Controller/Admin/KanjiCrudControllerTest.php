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

        $this->client->request('GET', $this->generateEditFormUrl(215));
        static::assertResponseRedirects('/connexion');

        $this->client->request('POST', $this->getCrudUrl('delete', 215));
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

        $this->client->request('GET', $this->generateNewFormUrl());
        static::assertResponseIsSuccessful();

        $this->client->request('GET', $this->generateDetailUrl(215));
        static::assertResponseIsSuccessful();

        $this->client->request('GET', $this->generateEditFormUrl(215));
        static::assertResponseIsSuccessful();
    }

    /**
     * testCreateEntityKanji.
     */
    public function testCreateEntityKanji(): void
    {
        $testUser = $this->findOneEntityBy(User::class, ['email' => 'admin@domaine.fr']);
        $this->client->loginUser($testUser);
        $crawler = $this->client->request('GET', $this->generateNewFormUrl());

        $form = $crawler->selectButton('Créer')->form();
        $form['Kanji[ideogramme]'] = 'ideogramme';
        $form['Kanji[signification]'] = 'signification';
        $form['Kanji[numberStroke]'] = '1';
        $form['Kanji[level]'] = 'JLPT 1';
        $this->client->submit($form);

        self::assertInstanceOf(Kanji::class, $this->findOneEntityBy(Kanji::class, ['ideogramme' => 'ideogramme']));
        self::assertResponseRedirects();

        $this->client->followRedirect();

        $this->assertSelectorTextContains('div', "'ideogramme' a été créé avec succès.");
    }

    /**
     * testUpdateEntityKanji.
     */
    public function testUpdateEntityKanji(): void
    {
        $testUser = $this->findOneEntityBy(User::class, ['email' => 'admin@domaine.fr']);
        $this->client->loginUser($testUser);
        $crawler = $this->client->request('GET', $this->generateEditFormUrl(215));

        $form = $crawler->selectButton('Sauvegarder les modifications')->form();
        $form['Kanji[signification]'] = 'update signification';
        $this->client->submit($form);

        $entityUpdate = $this->findEntity(Kanji::class, 215);

        self::assertInstanceOf(Kanji::class, $entityUpdate);
        self::assertEquals('update signification', $entityUpdate->getSignification());
        self::assertResponseRedirects();

        $this->client->followRedirect();

        $this->assertSelectorTextContains('div', "'困' a été mis à jour avec succès.");
    }
}
