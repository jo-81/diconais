<?php

namespace App\Entity;

use App\Repository\ResourceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ORM\Entity(repositoryClass: ResourceRepository::class)]
#[UniqueEntity('name')]
class Resource
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\Length(
        min: 3,
        minMessage: 'Ce champ doit avoir un minimum de {{ limit }} caractères',
    )]
    private ?string $name = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT)]
    #[NotBlank]
    private ?string $content = null;

    #[ORM\OneToMany(mappedBy: 'resource', targetEntity: ResourceSocial::class)]
    #[Assert\Valid]
    private Collection $socials;

    private Collection $plainSocials;

    public function __construct()
    {
        $this->socials = new ArrayCollection();
        $this->plainSocials = new ArrayCollection();
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Collection<int, ResourceSocial>
     */
    public function getSocials(): Collection
    {
        return $this->socials;
    }

    public function addSocial(ResourceSocial $social): static
    {
        if (!$this->socials->contains($social)) {
            $this->socials->add($social);
            $social->setResource($this);
        }

        return $this;
    }

    public function removeSocial(ResourceSocial $social): static
    {
        if ($this->socials->removeElement($social)) {
            if ($social->getResource() === $this) {
                $social->setResource(null);
            }
        }

        return $this;
    }

    public function getPlainSocials(): Collection
    {
        return $this->plainSocials;
    }

    public function setPlainSocials(Collection $plainSocials): static
    {
        $this->plainSocials = $plainSocials;

        return $this;
    }
}
