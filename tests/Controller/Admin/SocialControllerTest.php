<?php

namespace App\Tests\Controller\Admin;

use App\Tests\Traits\LoginTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SocialControllerTest extends WebTestCase
{
    use LoginTrait;

    /**
     * testRouteAccessWhenUserNotLogged.
     *
     * @dataProvider getAdminSocialRoutes
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
     * @dataProvider getAdminSocialRoutes
     */
    public function testRouteAccessWhenUserLogged(string $path): void
    {
        $client = static::createClient();
        $this->login($client, 'admin');
        $client->request('GET', $path);

        $this->assertResponseIsSuccessful();
    }

    /**
     * getAdminSocialRoutes.
     *
     * @return array<array<string>>
     */
    public function getAdminSocialRoutes(): array
    {
        return [
            ['/admin/socials'],
            ['/admin/socials/1'],
            ['/admin/socials/add'],
        ];
    }
}
