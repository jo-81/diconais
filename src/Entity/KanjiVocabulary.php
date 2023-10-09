<?php

namespace App\Entity;

use App\Repository\KanjiVocabularyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: KanjiVocabularyRepository::class)]
class KanjiVocabulary
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $signification = null;

    #[ORM\Column(length: 255)]
    private ?string $kana = null;

    #[ORM\Column(length: 255)]
    private ?string $kanji = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Kanji $ideogramme = null;

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

    public function getKana(): ?string
    {
        return $this->kana;
    }

    public function setKana(string $kana): static
    {
        $this->kana = $kana;

        return $this;
    }

    public function getKanji(): ?string
    {
        return $this->kanji;
    }

    public function setKanji(string $kanji): static
    {
        $this->kanji = $kanji;

        return $this;
    }

    public function getIdeogramme(): ?Kanji
    {
        return $this->ideogramme;
    }

    public function setIdeogramme(?Kanji $ideogramme): static
    {
        $this->ideogramme = $ideogramme;

        return $this;
    }
}
