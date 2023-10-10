<?php

namespace App\Entity;

use App\Repository\KanjiRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: KanjiRepository::class)]
class Kanji
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $ideogramme = null;

    #[ORM\Column]
    private ?int $numberKey = null;

    #[ORM\Column(length: 20)]
    private ?string $level = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $onReading = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $kunReading = null;

    #[ORM\Column]
    private ?int $numberStroke = null;

    #[ORM\Column]
    private ?bool $published = null;

    /** @var array<string> */
    #[ORM\Column(nullable: true)]
    private ?array $similars = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?File $file = null;

    #[ORM\OneToOne(targetEntity: self::class)]
    private ?self $key = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNumberKey(): ?int
    {
        return $this->numberKey;
    }

    public function setNumberKey(int $numberKey): static
    {
        $this->numberKey = $numberKey;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(string $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function getOnReading(): ?string
    {
        return $this->onReading;
    }

    public function setOnReading(?string $onReading): static
    {
        $this->onReading = $onReading;

        return $this;
    }

    public function getKunReading(): ?string
    {
        return $this->kunReading;
    }

    public function setKunReading(?string $kunReading): static
    {
        $this->kunReading = $kunReading;

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

    public function isPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): static
    {
        $this->published = $published;

        return $this;
    }

    /**
     * getSimilars.
     *
     * @return array<string>|null
     */
    public function getSimilars(): ?array
    {
        return $this->similars;
    }

    /**
     * setSimilars.
     *
     * @param array<string>|null $similars
     */
    public function setSimilars(?array $similars): static
    {
        $this->similars = $similars;

        return $this;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(File $file): static
    {
        $this->file = $file;

        return $this;
    }

    public function getKey(): ?self
    {
        return $this->key;
    }

    public function setKey(?self $key): static
    {
        $this->key = $key;

        return $this;
    }
}
