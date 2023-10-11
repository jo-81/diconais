<?php

namespace App\Tests\Traits;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

trait LoginTrait
{
    public function login(KernelBrowser $client, string $username): User|null
    {
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByUsername($username); /* @phpstan-ignore-line */
        $client->loginUser($testUser);

        return $testUser;
    }
}
