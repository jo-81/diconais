<?php

namespace App\Tests\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RessourceControllerTest extends WebTestCase
{
    public function testRouteExist(): void
    {
        $client = static::createClient();
        $client->request('GET', 'sources');

        $this->assertResponseIsSuccessful();
    }
}
