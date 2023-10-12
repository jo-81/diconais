<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Tests\Traits\ValidatorTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class UserTest extends KernelTestCase
{
    use ValidatorTrait;

    abstract public function getUser(): User;

    /**
     * testPasswordNotContainNumber
     * Si le mot de passe ne contient pas de nombre.
     */
    public function testPasswordNotContainNumber(): void
    {
        $user = $this->getUser();

        $user->setPlainPassword('Azertyuiopqsdf');
        $this->assertHasErrors($user, 1);
    }

    /**
     * testPasswordNotContainMajuscule
     * Si le mot de passe ne comtient pas de majuscule.
     *
     * @return void
     */
    public function testPasswordNotContainMajuscule()
    {
        $user = $this->getUser();

        $user->setPlainPassword('azertyuiopqsdf');
        $this->assertHasErrors($user, 1);
    }

    /**
     * testPasswordLengthCaracteres
     * Si le mot de passe ne contient pas au minimum 10 caractères.
     *
     * @return void
     */
    public function testPasswordLengthCaracteres()
    {
        $user = $this->getUser();

        $user->setPlainPassword('azert');
        $this->assertHasErrors($user, 1);
    }

    /**
     * testGoodPassword.
     */
    public function testGoodPassword(): void
    {
        $user = $this->getUser();

        $this->assertHasErrors($user, 0);
    }
}
