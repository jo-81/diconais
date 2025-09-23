<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\VocabularyRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: VocabularyRepository::class)]
class Vocabulary
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $signification = null;

    #[ORM\ManyToOne(inversedBy: 'vocabularies')]
    private ?Theme $theme = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reading = null;

    /**
     * @var Collection<int, Kanji>
     */
    #[ORM\ManyToMany(targetEntity: Kanji::class, inversedBy: 'vocabularies')]
    private Collection $kanjis;

    #[ORM\Column(length: 255)]
    private ?string $romaji = null;

    public function __construct()
    {
        $this->kanjis = new ArrayCollection();
    }

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

    public function getTheme(): ?Theme
    {
        return $this->theme;
    }

    public function setTheme(?Theme $theme): static
    {
        $this->theme = $theme;

        return $this;
    }

    public function getReading(): ?string
    {
        return $this->reading;
    }

    public function setReading(?string $reading): static
    {
        $this->reading = $reading;

        return $this;
    }

    public function __toString()
    {
        return $this->signification;
    }

    /**
     * @return Collection<int, Kanji>
     */
    public function getKanjis(): Collection
    {
        return $this->kanjis;
    }

    public function addKanji(Kanji $kanji): static
    {
        if (!$this->kanjis->contains($kanji)) {
            $this->kanjis->add($kanji);
        }

        return $this;
    }

    public function removeKanji(Kanji $kanji): static
    {
        $this->kanjis->removeElement($kanji);

        return $this;
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
}
