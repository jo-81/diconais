<?php

namespace App\Tests\Controller\Admin;

use App\Entity\User;
use App\Entity\Category;
use App\Tests\Traits\EntityFinderTrait;
use App\Controller\Admin\DashboardController;
use App\Tests\Traits\AdminCrudAssertionsTrait;
use App\Controller\Admin\CategoryCrudController;
use App\Tests\Traits\CrudAuthenticationTestTrait;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use EasyCorp\Bundle\EasyAdminBundle\Test\AbstractCrudTestCase;

final class CategoryCrudControllerTest extends AbstractCrudTestCase
{
    /**
     * @use EntityFinderTrait<Category>
     */
    use EntityFinderTrait;
    use ReloadDatabaseTrait;
    use CrudAuthenticationTestTrait;
    use AdminCrudAssertionsTrait;

    protected function getControllerFqcn(): string
    {
        return CategoryCrudController::class;
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
     * testCreateEntityCategory.
     */
    public function testCreateEntityCategory(): void
    {
        $testUser = $this->findOneEntityBy(User::class, ['email' => 'admin@domaine.fr']);
        $this->client->loginUser($testUser);
        $crawler = $this->client->request('GET', $this->generateNewFormUrl());

        $form = $crawler->selectButton('Créer')->form();
        $form['Category[name]'] = 'category 2';
        $form['Category[slug]'] = 'category-2';
        $form['Category[color]'] = 'red';
        $this->client->submit($form);

        self::assertInstanceOf(Category::class, $this->findOneEntityBy(Category::class, ['name' => 'category 2']));

        $this->assertEntityCreated('category 2');
    }

    /**
     * testUpdateEntityCategory.
     */
    public function testUpdateEntityCategory(): void
    {
        $testUser = $this->findOneEntityBy(User::class, ['email' => 'admin@domaine.fr']);
        $this->client->loginUser($testUser);
        $crawler = $this->client->request('GET', $this->generateEditFormUrl(1));

        $form = $crawler->selectButton('Sauvegarder les modifications')->form();
        $form['Category[name]'] = 'category update';
        $this->client->submit($form);

        $entityUpdate = $this->findEntity(Category::class, 1);

        self::assertInstanceOf(Category::class, $entityUpdate);
        $this->assertEntityUpdated('category update');
    }
}
