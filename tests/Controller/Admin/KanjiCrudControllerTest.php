<?php

namespace App\Tests\Controller\Admin;

use App\Entity\User;
use App\Entity\Kanji;
use App\Tests\Traits\EntityFinderTrait;
use App\Controller\Admin\DashboardController;
use App\Controller\Admin\KanjiCrudController;
use App\Tests\Traits\AdminCrudAssertionsTrait;
use App\Tests\Traits\CrudAuthenticationTestTrait;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use EasyCorp\Bundle\EasyAdminBundle\Test\AbstractCrudTestCase;

class KanjiCrudControllerTest extends AbstractCrudTestCase
{
    /**
     * @use EntityFinderTrait<Kanji>
     */
    use EntityFinderTrait;
    use ReloadDatabaseTrait;
    use CrudAuthenticationTestTrait;
    use AdminCrudAssertionsTrait;

    protected function getControllerFqcn(): string
    {
        return KanjiCrudController::class;
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
            ['detail', 215],
            ['edit', 215],
        ];
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

        $this->assertEntityCreated('ideogramme');
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

        $this->assertEntityUpdated('困');
    }
}
