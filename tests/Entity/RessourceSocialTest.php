<?php

namespace App\Tests\Entity;

use App\Entity\Resource;
use App\Entity\ResourceSocial;
use App\Repository\ResourceRepository;
use App\Tests\Traits\EntityTrait;
use App\Tests\Traits\ValidatorTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RessourceSocialTest extends WebTestCase
{
    use ValidatorTrait;
    use EntityTrait;

    public function getRessourceSocial(): ResourceSocial
    {
        /** @var resource $ressource */
        $ressource = $this->getEntity(['id' => 1], ResourceRepository::class);

        return (new ResourceSocial())
            ->setLink('une resource')
            ->setIcon('https://127.0.0.1:8000/admin/resources')
            ->setResource($ressource)
        ;
    }

    public function testBadLink(): void
    {
        $social = $this->getRessourceSocial();
        $social->setLink('rrrrr');

        $this->assertHasErrors($social, 1);
    }
}
