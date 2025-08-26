<?php

namespace App\Tests\Controller;

use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ResetPasswordControllerTest extends WebTestCase
{
    #[DataProvider('getDataProviderPath')]
    public function testRouteExists(string $path): void
    {
        $client = static::createClient();
        $client->request('GET', $path);

        $this->assertResponseIsSuccessful();
    }
    
    /**
     * getDataProviderPath
     *
     * @return array<string[]>
     */
    public static function getDataProviderPath(): array
    {
        return [
            ['/mot-de-passe-oublie'],
            ['/mot-de-passe-oublie/verification-email'],
        ];
    }
}
