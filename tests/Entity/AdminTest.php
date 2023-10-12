<?php

namespace App\Tests\Entity;

use App\Entity\Admin;
use App\Entity\User;

class AdminTest extends UserTest
{
    public function getUser(): User
    {
        return (new Admin())
            ->setUsername('usertest')
            ->setEmail('usertest@domaine.fr')
            ->setPlainPassword('Azerty2000')
        ;
    }
}
