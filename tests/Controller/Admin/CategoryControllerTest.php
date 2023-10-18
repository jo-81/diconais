<?php

namespace App\Tests\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerTest extends WebTestCase
{
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
     * getAdminCategoryRoutes.
     *
     * @return array<array<string>>
     */
    public function getAdminCategoryRoutes(): array
    {
        return [
            ['/admin/categories'],
        ];
    }
}
