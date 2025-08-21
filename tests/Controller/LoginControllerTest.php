<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    /**
     * testLoginPageExist.
     */
    public function testLoginPageExist(): void
    {
        $client = static::createClient();
        $client->request('GET', '/connexion');

        $this->assertResponseIsSuccessful();
    }

    /**
     * testLoginWithValidCredentials.
     */
    public function testLoginWithValidCredentials(): void
    {
        $client = static::createClient();
        $client->request('GET', '/connexion');

        $client->submitForm('Connexion', [
            '_username' => 'admin@domaine.fr',
            '_password' => '0',
        ]);

        self::assertResponseRedirects('/admin');
        $client->followRedirect();

        self::assertSelectorNotExists('.alert-danger');
        self::assertResponseIsSuccessful();
    }

    /**
     * testLoginWithNotValidCredentials.
     */
    public function testLoginWithNotValidCredentials(): void
    {
        $client = static::createClient();
        $client->request('GET', '/connexion');

        $client->submitForm('Connexion', [
            '_username' => 'bhggyuivadmin@domaine.fr',
            '_password' => '012',
        ]);

        self::assertResponseRedirects('/connexion');
        $client->followRedirect();

        self::assertSelectorTextContains('.alert-danger', 'Identifiants invalides.');
    }
}
