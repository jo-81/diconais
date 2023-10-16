<?php

namespace App\Service\Profil;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class AccountService
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function edit(User $user): void
    {
        $this->em->flush();
    }
}
