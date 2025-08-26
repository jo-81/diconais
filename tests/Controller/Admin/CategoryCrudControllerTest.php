<?php

namespace App\Tests\Controller\Admin;

use App\Entity\User;
use App\Entity\Category;
use App\Tests\Traits\EntityFinderTrait;
use App\Controller\Admin\DashboardController;
use App\Controller\Admin\CategoryCrudController;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use EasyCorp\Bundle\EasyAdminBundle\Test\AbstractCrudTestCase;

final class CategoryCrudControllerTest extends AbstractCrudTestCase
{
    /**
     * @use EntityFinderTrait<Category>
     */
    use EntityFinderTrait;
    use ReloadDatabaseTrait;

    protected function getControllerFqcn(): string
    {
        return CategoryCrudController::class;
    }

    protected function getDashboardFqcn(): string
    {
        return DashboardController::class;
    }

    /**
     * testCategoryPageWhenUserNotLogged.
     */
    public function testCategoryPageWhenUserNotLogged(): void
    {
        $this->client->request('GET', $this->generateIndexUrl());
        static::assertResponseRedirects('/connexion');

        $this->client->request('GET', $this->generateNewFormUrl());
        static::assertResponseRedirects('/connexion');
    }

    /**
     * testCategoryPageWhenUserLogged.
     */
    public function testCategoryPageWhenUserLogged(): void
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        $testUser = $userRepository->findOneByEmail('admin@domaine.fr');
        $this->client->loginUser($testUser);

        $this->client->request('GET', $this->generateIndexUrl());
        static::assertResponseIsSuccessful();

        $this->client->request('GET', $this->generateNewFormUrl());
        static::assertResponseIsSuccessful();
    }

    public function testCreateEntityCategory(): void
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        $testUser = $userRepository->findOneByEmail('admin@domaine.fr');
        $this->client->loginUser($testUser);
        $crawler = $this->client->request('GET', $this->generateNewFormUrl());

        $form = $crawler->selectButton('Créer')->form();
        $form['Category[name]'] = 'category 2';
        $form['Category[slug]'] = 'category-2';
        $form['Category[color]'] = 'red';
        $this->client->submit($form);

        self::assertInstanceOf(Category::class, $this->findOneEntityBy(Category::class, ['name' => 'category 2']));

        self::assertResponseRedirects();
        $this->client->followRedirect();
        $this->assertSelectorTextContains('div', "'category 2' a été créé avec succès.");
    }
}
