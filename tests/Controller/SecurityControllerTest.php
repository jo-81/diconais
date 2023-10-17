<?php

namespace App\Tests\Controller;

use App\Tests\Traits\LoginTrait;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    use ReloadDatabaseTrait;
    use LoginTrait;

    /**
     * testExistRouteLogin
     * Test si la route /connexion existe.
     */
    public function testExistRouteLogin(): void
    {
        $client = static::createClient();
        $client->request('GET', '/connexion');

        $this->assertResponseIsSuccessful();
    }

    /**
     * testGoodCredentials.
     */
    public function testGoodCredentials(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/connexion');

        $form = $crawler->selectButton('Connexion')->form();
        $form['username'] = 'admin';
        $form['password'] = '0';
        $client->submit($form);

        $this->assertResponseRedirects('/profil/mon-compte');
    }

    /**
     * testBadCredentials.
     */
    public function testBadCredentials(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/connexion');

        $form = $crawler->selectButton('Connexion')->form();
        $form['username'] = 'ad7min';
        $form['password'] = '00';
        $client->submit($form);

        $this->assertResponseRedirects('/connexion');
    }

    public function testLoginWhenUserAlreadyConnected(): void
    {
        $client = static::createClient();
        $this->login($client, 'admin');

        $client->request('GET', '/connexion');
        $this->assertResponseRedirects('/');
    }
}
