<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\IdeogrammeRepository;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;

#[InheritanceType('JOINED')]
#[DiscriminatorColumn(name: 'discr', type: 'string')]
#[DiscriminatorMap(['ideogramme' => Ideogramme::class, 'kanji' => Kanji::class, 'key' => Key::class])]
#[ORM\Entity(repositoryClass: IdeogrammeRepository::class)]
abstract class Ideogramme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[NotBlank(message: 'Ce champ ne peut pas être vide.')]
    #[ORM\Column(length: 255)]
    protected ?string $signification = null;

    #[Assert\Positive(message: 'Ce champ doit avoir une valeur strictement positive.')]
    #[ORM\Column()]
    protected ?int $numberStroke = null;

    #[ORM\Column(length: 255, nullable: true)]
    protected ?string $kunyomi = null;

    #[NotBlank(message: 'Ce champ ne peut pas être vide.')]
    #[ORM\Column(length: 255)]
    protected ?string $ideogramme = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSignification(): ?string
    {
        return $this->signification;
    }

    public function setSignification(string $signification): static
    {
        $this->signification = $signification;

        return $this;
    }

    public function getNumberStroke(): ?int
    {
        return $this->numberStroke;
    }

    public function setNumberStroke(int $numberStroke): static
    {
        $this->numberStroke = $numberStroke;

        return $this;
    }

    public function getKunyomi(): ?string
    {
        return $this->kunyomi;
    }

    public function setKunyomi(?string $kunyomi): static
    {
        $this->kunyomi = $kunyomi;

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

    public function __toString()
    {
        return $this->ideogramme;
    }
}
