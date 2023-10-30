<?php

namespace App\Tests\Controller\Admin;

use App\Repository\ResourceRepository;
use App\Tests\Traits\LoginTrait;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RessourceControllerTest extends WebTestCase
{
    use LoginTrait;
    use ReloadDatabaseTrait;

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

    public function testAddRessourceUserNotLogged(): void
    {
        $client = static::createClient();
        $client->request('POST', '/admin/resources/add');

        $this->assertResponseRedirects('/connexion');
    }

    public function testAddRessourceUserLogged(): void
    {
        $client = static::createClient();
        $this->login($client, 'admin');
        $crawler = $client->request('GET', '/admin/resources/add');

        $form = $crawler->selectButton('ajouter')->form();
        $form['ressource[name]'] = 'une resource au hasard';
        $form['ressource[content]'] = 'Le contenue de cette resource';

        $client->submit($form);

        /** @var ResourceRepository */
        $repository = static::getContainer()->get(ResourceRepository::class);

        $this->assertCount(11, $repository->findAll());
        $this->assertResponseRedirects('/admin/resources');
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
            ['/admin/resources/1'],
            ['/admin/resources/add'],
        ];
    }
}
