<?php

namespace App\Tests\Entity;

use App\Entity\Social;
use App\Tests\Traits\ValidatorTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SocialTest extends WebTestCase
{
    use ValidatorTrait;

    public function getSocial(): Social
    {
        return (new Social())
            ->setName('un réseau social')
            ->setColor('#000000')
            ->setIcon('une-icon')
        ;
    }

    public function testBadName(): void
    {
        $social = $this->getSocial();

        $social->setName('u');
        $this->assertHasErrors($social, 1);
    }

    public function testUniqueName(): void
    {
        $social = $this->getSocial();

        $social->setName('Facebook');
        $this->assertHasErrors($social, 1);
    }

    public function testBadColor(): void
    {
        $Social = $this->getSocial();

        $Social->setColor('uferf');
        $this->assertHasErrors($Social, 1);
    }

    public function testGoodSocial(): void
    {
        $this->assertHasErrors($this->getSocial(), 0);
    }
}
