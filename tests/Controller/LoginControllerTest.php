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

        // self::assertResponseRedirects('/admin');
        $client->followRedirect();

        self::assertSelectorNotExists('.alert-danger');
        self::assertResponseRedirects();
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

    public function testLoginThrottlingBlocksAfterMaxAttempts(): void
    {
        $client = static::createClient();

        $maxAttempts = 5;
        $loginUrl = '/connexion';

        for ($i = 0; $i < $maxAttempts; ++$i) {
            $crawler = $client->request('GET', $loginUrl);
            $form = $crawler->selectButton('Connexion')->form([
                '_username' => 'wrong_user',
                '_password' => 'wrong_pass',
            ]);
            $client->submit($form);

            $this->assertResponseStatusCodeSame(302);
        }

        // Tentative suivante dépassant la limite
        $crawler = $client->request('GET', $loginUrl);
        $form = $crawler->selectButton('Connexion')->form([
            '_username' => 'wrong_user',
            '_password' => 'wrong_pass',
        ]);
        $client->submit($form);

        $this->assertResponseStatusCodeSame(302);
        $client->followRedirect();

        self::assertSelectorTextContains('.alert-danger', 'Plusieurs tentatives de connexion ont échoué, veuillez réessayer dans 1 minute.');
    }
}
