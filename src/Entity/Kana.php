<?php

namespace App\Entity;

use App\Enum\KanaTypeEnum;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\KanaRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: KanaRepository::class)]
class Kana
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: 'Ce champ ne peut pas être vide.')]
    #[ORM\Column(length: 100)]
    private ?string $romaji = null;

    #[Assert\NotBlank(message: 'Ce champ ne peut pas être vide.')]
    #[ORM\Column(length: 100)]
    private ?string $kunrei = null;

    #[ORM\Column]
    private ?bool $accent = null;

    #[ORM\Column]
    private ?bool $combination = null;

    #[Assert\NotBlank(message: 'Ce champ ne peut pas être vide.')]
    #[ORM\Column(length: 100)]
    private ?string $ideogramme = null;

    #[ORM\Column(enumType: KanaTypeEnum::class)]
    private ?KanaTypeEnum $type = null;

    #[ORM\Column]
    private ?int $position = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRomaji(): ?string
    {
        return $this->romaji;
    }

    public function setRomaji(string $romaji): static
    {
        $this->romaji = $romaji;

        return $this;
    }

    public function getKunrei(): ?string
    {
        return $this->kunrei;
    }

    public function setKunrei(string $kunrei): static
    {
        $this->kunrei = $kunrei;

        return $this;
    }

    public function isAccent(): ?bool
    {
        return $this->accent;
    }

    public function setAccent(bool $accent): static
    {
        $this->accent = $accent;

        return $this;
    }

    public function isCombination(): ?bool
    {
        return $this->combination;
    }

    public function setCombination(bool $combination): static
    {
        $this->combination = $combination;

        return $this;
    }

    public function getIdeogramme(): ?string
    {
        return $this->ideogramme;
    }

    public function setIdeogramme(string $ideogramme): static
    {
        $this->ideogramme = $ideogramme;

        return $this;
    }

    public function getType(): ?KanaTypeEnum
    {
        return $this->type;
    }

    public function setType(KanaTypeEnum $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function __toString()
    {
        return $this->ideogramme;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;

        return $this;
    }
}
