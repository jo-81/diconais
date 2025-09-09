<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\IdeogrammeRepository;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use App\Entity\Kanji;

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

    #[ORM\Column(length: 255)]
    protected ?string $signification = null;

    #[ORM\Column(length: 255)]
    protected ?string $numberStroke = null;

    #[ORM\Column(length: 255, nullable: true)]
    protected ?string $kunyomi = null;

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

    public function getNumberStroke(): ?string
    {
        return $this->numberStroke;
    }

    public function setNumberStroke(string $numberStroke): static
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
}
