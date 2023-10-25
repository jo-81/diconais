<?php

namespace App\Tests\Controller\Admin;

use App\Tests\Traits\LoginTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RessourceControllerTest extends WebTestCase
{
    use LoginTrait;

    /**
     * testRouteAccessWhenUserNotLogged.
     *
     * @dataProvider getAdminRessourceRoutes
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
     * @dataProvider getAdminRessourceRoutes
     */
    public function testRouteAccessWhenUserLogged(string $path): void
    {
        $client = static::createClient();
        $this->login($client, 'admin');
        $client->request('GET', $path);

        $this->assertResponseIsSuccessful();
    }

    /**
     * getAdminRessourceRoutes.
     *
     * @return array<array<string>>
     */
    public function getAdminRessourceRoutes(): array
    {
        return [
            ['/admin/resources'],
        ];
    }
}
