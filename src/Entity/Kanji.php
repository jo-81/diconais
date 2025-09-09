<?php

namespace App\Entity;

use App\Enum\JlptLevelEnum;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\KanjiRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: KanjiRepository::class)]
class Kanji extends Ideogramme
{
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $onyomi = null;

    /**
     * @var Collection<int, Key>
     */
    #[ORM\ManyToMany(targetEntity: Key::class, inversedBy: 'kanjis')]
    private Collection $associatedKey;

    /**
     * @var Collection<int, self>
     */
    #[ORM\ManyToMany(targetEntity: self::class)]
    private Collection $similars;

    #[ORM\Column(nullable: true, enumType: JlptLevelEnum::class)]
    private ?JlptLevelEnum $level = null;

    public function __construct()
    {
        $this->associatedKey = new ArrayCollection();
        $this->similars = new ArrayCollection();
    }

    public function getOnyomi(): ?string
    {
        return $this->onyomi;
    }

    public function setOnyomi(?string $onyomi): static
    {
        $this->onyomi = $onyomi;

        return $this;
    }

    /**
     * @return Collection<int, Key>
     */
    public function getAssociatedKey(): Collection
    {
        return $this->associatedKey;
    }

    public function addAssociatedKey(Key $associatedKey): static
    {
        if (!$this->associatedKey->contains($associatedKey)) {
            $this->associatedKey->add($associatedKey);
        }

        return $this;
    }

    public function removeAssociatedKey(Key $associatedKey): static
    {
        $this->associatedKey->removeElement($associatedKey);

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getSimilars(): Collection
    {
        return $this->similars;
    }

    public function addSimilar(self $similar): static
    {
        if (!$this->similars->contains($similar)) {
            $this->similars->add($similar);
        }

        return $this;
    }

    public function removeSimilar(self $similar): static
    {
        $this->similars->removeElement($similar);

        return $this;
    }

    public function getLevel(): ?JlptLevelEnum
    {
        return $this->level;
    }

    public function setLevel(?JlptLevelEnum $level): static
    {
        $this->level = $level;

        return $this;
    }
}
