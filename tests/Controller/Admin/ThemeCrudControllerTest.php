<?php

namespace App\Tests\Controller\Admin;

use App\Entity\User;
use App\Entity\Theme;
use App\Tests\Traits\EntityFinderTrait;
use App\Controller\Admin\DashboardController;
use App\Controller\Admin\ThemeCrudController;
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
        return ThemeCrudController::class;
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

        $this->client->request('GET', $this->generateNewFormUrl());
        static::assertResponseRedirects('/connexion');

        $this->client->request('GET', $this->generateEditFormUrl(1));
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

        $this->client->request('GET', $this->generateNewFormUrl());
        static::assertResponseIsSuccessful();

        $this->client->request('GET', $this->generateEditFormUrl(1));
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
        $form['Theme[name]'] = 'ideogramme';
        $form['Theme[slug]'] = 'ideogramme';
        $form['Theme[description]'] = 'description';
        $this->client->submit($form);

        self::assertInstanceOf(Theme::class, $this->findOneEntityBy(Theme::class, ['name' => 'ideogramme']));
        self::assertResponseRedirects();

        $this->client->followRedirect();

        $this->assertSelectorTextContains('div', "'ideogramme' a été créé avec succès.");
    }

    public function testUpdateEntityKanji(): void
    {
        $testUser = $this->findOneEntityBy(User::class, ['email' => 'admin@domaine.fr']);
        $this->client->loginUser($testUser);
        $crawler = $this->client->request('GET', $this->generateEditFormUrl(1));

        $form = $crawler->selectButton('Sauvegarder les modifications')->form();
        $form['Theme[name]'] = 'update theme';
        $this->client->submit($form);

        $entityUpdate = $this->findEntity(Theme::class, 1);

        self::assertInstanceOf(Theme::class, $entityUpdate);
        self::assertEquals('update theme', $entityUpdate->getName());
        self::assertResponseRedirects();

        $this->client->followRedirect();

        $this->assertSelectorTextContains('div', "'update theme' a été mis à jour avec succès.");
    }
}
