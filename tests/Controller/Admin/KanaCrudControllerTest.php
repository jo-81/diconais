<?php

namespace App\Tests\Controller\Admin;

use App\Entity\Kana;
use App\Entity\User;
use App\Tests\Traits\EntityFinderTrait;
use App\Controller\Admin\KanaCrudController;
use App\Controller\Admin\DashboardController;
use App\Tests\Traits\AdminCrudAssertionsTrait;
use App\Tests\Traits\CrudAuthenticationTestTrait;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use EasyCorp\Bundle\EasyAdminBundle\Test\AbstractCrudTestCase;

class KanaCrudControllerTest extends AbstractCrudTestCase
{
    /**
     * @use EntityFinderTrait<Kana>
     */
    use EntityFinderTrait;
    use ReloadDatabaseTrait;
    use CrudAuthenticationTestTrait;
    use AdminCrudAssertionsTrait;

    protected function getControllerFqcn(): string
    {
        return KanaCrudController::class;
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

        $this->assertEntityCreated('や');
    }

    /**
     * testUpdateEntityKana.
     */
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

        $this->assertEntityUpdated('あ');
    }
}
