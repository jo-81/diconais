<?php

namespace App\Tests\Controller\Admin;

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
        ];
    }
}
