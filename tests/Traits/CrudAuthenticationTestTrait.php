<?php

namespace App\Tests\Traits;

use App\Entity\User;
use PHPUnit\Framework\Attributes\DataProvider;
use EasyCorp\Bundle\EasyAdminBundle\Test\AbstractCrudTestCase;

trait CrudAuthenticationTestTrait
{
    /**
     * @return array<int, list<int|string>>
     */
    abstract public static function provideProtectedUrls(): iterable;

    #[DataProvider('provideProtectedUrls')]
    public function testProtectedUrlsRequireAuthentication(string $type, ?int $entityId = null, string $method = 'GET'): void
    {
        $this->extendsAbstractCrudTestCase();
        $url = $this->buildUrlFromType($type, $entityId);

        $this->client->request($method, $url);
        static::assertResponseRedirects('/connexion');
    }

    #[DataProvider('provideProtectedUrls')]
    public function testProtectedUrlsRequireAuthenticationWhenUserLogged(string $type, ?int $entityId = null, string $method = 'GET'): void
    {
        $this->extendsAbstractCrudTestCase();
        $url = $this->buildUrlFromType($type, $entityId);

        $userRepository = $this->entityManager->getRepository(User::class);
        $testUser = $userRepository->findOneByEmail('admin@domaine.fr');
        $this->client->loginUser($testUser);

        $this->client->request($method, $url);
        static::assertResponseIsSuccessful();
    }

    private function buildUrlFromType(string $type, ?int $entityId = null): string
    {
        return $this->getCrudUrl($type, $entityId);
    }

    private function extendsAbstractCrudTestCase(): void
    {
        if (!$this instanceof AbstractCrudTestCase) {
            throw new \RuntimeException(sprintf("La classe %s n'étends pas de la classe de test AbstractCrudTestCase", get_class($this)));
        }
    }
}
