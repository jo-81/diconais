<?php

namespace App\Tests\Entity;

use App\Entity\Resource;
use App\Tests\Traits\ValidatorTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RessourceTest extends WebTestCase
{
    use ValidatorTrait;

    public function getRessource(): Resource
    {
        return (new Resource())
            ->setName('une resource')
            ->setContent('Le contenue d\'une resource')
        ;
    }

    public function testBadName(): void
    {
        $ressource = $this->getRessource();

        $ressource->setName('u');
        $this->assertHasErrors($ressource, 1);
    }

    public function testUniqueName(): void
    {
        $ressource = $this->getRessource();

        $ressource->setName('resource');
        $this->assertHasErrors($ressource, 1);
    }

    public function testEmptyContent(): void
    {
        $ressource = $this->getRessource();

        $ressource->setContent('');
        $this->assertHasErrors($ressource, 1);
    }

    public function testGoodRessource(): void
    {
        $this->assertHasErrors($this->getRessource(), 0);
    }
}
