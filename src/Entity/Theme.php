<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ThemeRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Validator\Constraints\NameAndSlugConstraints;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[UniqueEntity('name')]
#[UniqueEntity('slug')]
#[ORM\Entity(repositoryClass: ThemeRepository::class)]
class Theme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[NameAndSlugConstraints]
    #[ORM\Column(length: 255, unique: true)]
    private ?string $name = null;

    #[NameAndSlugConstraints]
    #[ORM\Column(length: 255, unique: true)]
    private ?string $slug = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<int, Vocabulary>
     */
    #[ORM\OneToMany(targetEntity: Vocabulary::class, mappedBy: 'theme')]
    private Collection $vocabularies;

    public function __construct()
    {
        $this->vocabularies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return Collection<int, Vocabulary>
     */
    public function getVocabularies(): Collection
    {
        return $this->vocabularies;
    }

    public function addVocabulary(Vocabulary $vocabulary): static
    {
        if (!$this->vocabularies->contains($vocabulary)) {
            $this->vocabularies->add($vocabulary);
            $vocabulary->setTheme($this);
        }

        return $this;
    }

    public function removeVocabulary(Vocabulary $vocabulary): static
    {
        if ($this->vocabularies->removeElement($vocabulary)) {
            // set the owning side to null (unless already changed)
            if ($vocabulary->getTheme() === $this) {
                $vocabulary->setTheme(null);
            }
        }

        return $this;
    }
}
