<?php

namespace App\Service\Social;

use App\Entity\Social;
use Doctrine\ORM\EntityManagerInterface;

class SocialService
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function persist(Social $Social): void
    {
        $this->em->persist($Social);
        $this->em->flush();
    }

    public function remove(Social $Social): void
    {
        $this->em->remove($Social);
        $this->em->flush();
    }
}
