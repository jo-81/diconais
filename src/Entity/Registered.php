<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\RegisteredRepository;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: RegisteredRepository::class)]
class Registered extends User
{
    #[ORM\Column]
    private ?\DateTimeImmutable $registerAt = null;

    public function getRegisterAt(): ?\DateTimeImmutable
    {
        return $this->registerAt;
    }

    public function setRegisterAt(\DateTimeImmutable $registerAt): static
    {
        $this->registerAt = $registerAt;

        return $this;
    }

    #[ORM\PrePersist]
    public function setPersistValues(): void
    {
        $this->registerAt = new \DateTimeImmutable();
        $this->roles = ['ROLE_REGISTERED'];
    }
}
