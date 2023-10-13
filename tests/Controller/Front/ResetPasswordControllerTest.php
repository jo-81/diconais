<?php

namespace App\Tests\Controller\Front;

use App\Entity\ForgetPassword;
use App\Repository\ForgetPasswordRepository;
use App\Repository\UserRepository;
use App\Tests\Traits\EntityTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ResetPasswordControllerTest extends WebTestCase
{
    use EntityTrait;

    /**
     * testReturnNotFoundWithoutToken.
     */
    public function testReturnNotFoundWithoutToken(): void
    {
        $client = static::createClient();
        $client->request('GET', '/renouvellement-mot-de-passe');

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    /**
     * testReturnNotFoundWitBadToken.
     */
    public function testReturnNotFoundWitBadToken(): void
    {
        $client = static::createClient();
        $client->request('GET', '/renouvellement-mot-de-passe/tokken');

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    /**
     * testReturnRouteWitGoodToken.
     */
    public function testReturnRouteWitGoodToken(): void
    {
        $client = static::createClient();

        $user = $this->getEntity(['username' => 'admin_2'], UserRepository::class);
        /** @var ForgetPassword */
        $forgetPassword = $this->getEntity(['person' => $user], ForgetPasswordRepository::class);

        $client->request('GET', '/renouvellement-mot-de-passe/'.$forgetPassword->getToken());

        $this->assertResponseIsSuccessful();
    }

    /**
     * testResetPasswordWithSameDatas
     * Si tout ce passe bien.
     */
    public function testResetPasswordWithSameDatas(): void
    {
        $client = static::createClient();

        $user = $this->getEntity(['username' => 'admin_2'], UserRepository::class);
        /** @var ForgetPassword */
        $forgetPassword = $this->getEntity(['person' => $user], ForgetPasswordRepository::class);

        /* Pour eviter que la demande soit expirée */
        $forgetPassword->setLimitedAt(new \DateTimeImmutable());

        $crawler = $client->request('GET', '/renouvellement-mot-de-passe/'.$forgetPassword->getToken());

        $form = $crawler->selectButton('valider')->form();
        $form['reset_password[plainPassword][first]'] = 'Azerty2000';
        $form['reset_password[plainPassword][second]'] = 'Azerty2000';
        $client->submit($form);

        $this->assertResponseRedirects('/connexion');
    }
}
