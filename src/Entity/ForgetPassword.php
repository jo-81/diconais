<?php

namespace App\Entity;

use App\Repository\ForgetPasswordRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ForgetPasswordRepository::class)]
class ForgetPassword
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne()]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?User $person = null;

    #[ORM\Column(length: 255)]
    private ?string $token = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $limitedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPerson(): ?User
    {
        return $this->person;
    }

    public function setPerson(User $person): static
    {
        $this->person = $person;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): static
    {
        $this->token = $token;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getLimitedAt(): ?\DateTimeImmutable
    {
        return $this->limitedAt;
    }

    public function setLimitedAt(\DateTimeImmutable $limitedAt): static
    {
        $this->limitedAt = $limitedAt;

        return $this;
    }
}
