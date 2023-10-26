<?php

namespace App\Tests\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RessourceControllerTest extends WebTestCase
{
    /**
     * @dataProvider getRessourceRoutes
     */
    public function testRouteExist(string $path): void
    {
        $client = static::createClient();
        $client->request('GET', $path);

        $this->assertResponseIsSuccessful();
    }

    /**
     * getRessourceRoutes.
     *
     * @return array<array<string>>
     */
    public function getRessourceRoutes(): array
    {
        return [
            ['/sources'],
            ['/sources/resource'],
        ];
    }
}
