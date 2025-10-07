<?php

namespace App\Tests\Controller\Admin;

use App\Entity\User;
use App\Entity\Theme;
use App\Tests\Traits\EntityFinderTrait;
use App\Controller\Admin\DashboardController;
use App\Controller\Admin\ThemeCrudController;
use App\Tests\Traits\AdminCrudAssertionsTrait;
use App\Tests\Traits\CrudAuthenticationTestTrait;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use EasyCorp\Bundle\EasyAdminBundle\Test\AbstractCrudTestCase;

class ThemeCrudControllerTest extends AbstractCrudTestCase
{
    /**
     * @use EntityFinderTrait<Theme>
     */
    use EntityFinderTrait;
    use ReloadDatabaseTrait;
    use CrudAuthenticationTestTrait;
    use AdminCrudAssertionsTrait;

    protected function getControllerFqcn(): string
    {
        return ThemeCrudController::class;
    }

    protected function getDashboardFqcn(): string
    {
        return DashboardController::class;
    }

    /**
     * @return array<int, list<int|string>>
     */
    public static function provideProtectedUrls(): iterable
    {
        return [
            ['index'],
            ['new'],
            ['detail', 1],
            ['edit', 1],
        ];
    }

    /**
     * testCreateEntityTheme.
     */
    public function testCreateEntityTheme(): void
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

        $this->assertEntityCreated('ideogramme');
    }

    /**
     * testUpdateEntityTheme.
     */
    public function testUpdateEntityTheme(): void
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

        $this->assertEntityUpdated('update theme');
    }
}
