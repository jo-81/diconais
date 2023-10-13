<?php

namespace App\Tests\Controller\Profile;

use App\Tests\Traits\LoginTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProfilControllerTest extends WebTestCase
{
    use LoginTrait;

    /**
     * @dataProvider getRoutesProfile
     */
    public function testAccessPageWhenUserNotLogged(string $path): void
    {
        $client = static::createClient();
        $client->request('GET', $path);

        $this->assertResponseRedirects('/connexion');
    }

    /**
     * @dataProvider getRoutesProfile
     */
    public function testAccessPageWhenUserLogged(string $path): void
    {
        $client = static::createClient();
        $this->login($client, 'admin');

        $client->request('GET', $path);
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
            ['/profil'],
            ['/profil/edit-password'],
        ];
    }
}
