<?php

namespace App\Tests\Controller;

use App\Tests\Traits\LoginTrait;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ForgetPasswordControllerTest extends WebTestCase
{
    use ReloadDatabaseTrait;
    use LoginTrait;

    /**
     * testExistAskResetPassword
     * Test si la route /demande-renouvellement-mot-de-passe existe.
     */
    public function testExistAskResetPassword(): void
    {
        $client = static::createClient();
        $client->request('GET', '/demande-renouvellement-mot-de-passe');

        $this->assertResponseIsSuccessful();
    }

    /**
     * testAskResetPasswordWithNotExistEmail
     * Si l'email renseigné n'existe pas.
     */
    public function testAskResetPasswordWithNotExistEmail(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/demande-renouvellement-mot-de-passe');

        $form = $crawler->selectButton('valider')->form();
        $form['email'] = 'admin@domaine.com';
        $client->submit($form);
        $client->followRedirect();

        $this->assertSelectorTextContains('.alert.alert-danger', "Aucun email n'existe");
    }

    /**
     * testAskResetPasswordExist
     * Si une demande existe déjà.
     */
    public function testAskResetPasswordExist(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/demande-renouvellement-mot-de-passe');

        $form = $crawler->selectButton('valider')->form();
        $form['email'] = 'admin_2@domaine.fr';
        $client->submit($form);
        $client->followRedirect();

        $this->assertSelectorTextContains('.alert.alert-info', 'Une demande existe déjà pour cette email');
    }

    /**
     * testAskResetPasswordWithExistEmail
     * Si l'email existe et aucune demande de fait.
     */
    public function testAskResetPasswordWithExistEmail(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/demande-renouvellement-mot-de-passe');

        $form = $crawler->selectButton('valider')->form();
        $form['email'] = 'admin@domaine.fr';
        $client->submit($form);
        $this->assertEmailCount(1);

        $client->followRedirect();
        $this->assertSelectorTextContains('.alert.alert-success', 'Un email vous a été envoyé');
    }

    public function testIfUserIsLogged(): void
    {
        $client = static::createClient();
        $this->login($client, 'admin');

        $client->request('GET', '/demande-renouvellement-mot-de-passe');
        $this->assertResponseRedirects('/');
    }
}
