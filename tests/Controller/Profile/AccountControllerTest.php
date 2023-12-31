<?php

namespace App\Tests\Controller\Profile;

use App\Tests\Traits\LoginTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AccountControllerTest extends WebTestCase
{
    use LoginTrait;

    /**
     * @dataProvider getRoutesProfile
     */
    public function testAccessPageWhenUserNotLogged(string $method): void
    {
        $client = static::createClient();
        $client->request($method, '/profil/mon-compte');

        $this->assertResponseRedirects('/connexion');
    }

    /**
     * @dataProvider getRoutesProfile
     */
    public function testAccessPageWhenUserLogged(string $method): void
    {
        $client = static::createClient();
        $this->login($client, 'admin');

        $client->request($method, '/profil/mon-compte');
        $this->assertResponseIsSuccessful();
    }

    /**
     * getRoutesProfile.
     *
     * @return array<mixed>
     */
    public function getRoutesProfile(): array
    {
        return [
            ['GET', 'POST'],
        ];
    }
}
