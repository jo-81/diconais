<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\KeyRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: KeyRepository::class)]
#[ORM\Table(name: '`key`')]
class Key extends Ideogramme
{
    #[ORM\Column]
    private ?int $number = null;

    /**
     * @var Collection<int, Kanji>
     */
    #[ORM\ManyToMany(targetEntity: Kanji::class, mappedBy: 'associatedKey')]
    private Collection $kanjis;

    public function __construct()
    {
        $this->kanjis = new ArrayCollection();
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): static
    {
        $this->number = $number;

        return $this;
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
            $kanji->addAssociatedKey($this);
        }

        return $this;
    }

    public function removeKanji(Kanji $kanji): static
    {
        if ($this->kanjis->removeElement($kanji)) {
            $kanji->removeAssociatedKey($this);
        }

        return $this;
    }
}
