<?php

namespace App\Tests\Controller\Admin;

use App\Repository\CategoryRepository;
use App\Tests\Traits\LoginTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerTest extends WebTestCase
{
    use LoginTrait;

    /**
     * testRouteAccessWhenUserNotLogged.
     *
     * @dataProvider getAdminCategoryRoutes
     */
    public function testRouteAccessWhenUserNotLogged(string $path): void
    {
        $client = static::createClient();
        $client->request('GET', $path);

        $this->assertResponseRedirects('/connexion');
    }

    /**
     * testRouteAccessWhenUserLogged.
     *
     * @dataProvider getAdminCategoryRoutes
     */
    public function testRouteAccessWhenUserLogged(string $path): void
    {
        $client = static::createClient();
        $this->login($client, 'admin');
        $client->request('GET', $path);

        $this->assertResponseIsSuccessful();
    }

    public function testAddCategoryWhenUserNotLogged(): void
    {
        $client = static::createClient();
        $client->request('POST', '/admin/categories/add');

        $this->assertResponseRedirects('/connexion');
    }

    public function testAddCategoryWhenUserLogged(): void
    {
        $client = static::createClient();
        $this->login($client, 'admin');
        $crawler = $client->request('GET', '/admin/categories/add');

        $form = $crawler->selectButton('ajouter')->form();
        $form['category[name]'] = 'une catégorie au hasard';
        $form['category[color]'] = '#4f4f4f';

        $client->submit($form);

        /** @var CategoryRepository */
        $repository = static::getContainer()->get(CategoryRepository::class);

        $this->assertCount(21, $repository->findAll());
    }

    /**
     * getAdminCategoryRoutes.
     *
     * @return array<array<string>>
     */
    public function getAdminCategoryRoutes(): array
    {
        return [
            ['/admin/categories'],
            ['/admin/categories/1'],
            ['/admin/categories/1/edit'],
            ['/admin/categories/add'],
        ];
    }
}
