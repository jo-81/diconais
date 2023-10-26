<?php

namespace App\Entity;

use App\Enum\SocialIconEnum;
use App\Repository\ResourceSocialRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResourceSocialRepository::class)]
class ResourceSocial
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $link = null;

    #[ORM\ManyToOne(targetEntity: Resource::class, inversedBy: 'socials')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Resource $resource = null;

    #[ORM\Column(type: 'enumiconsocial')]
    private ?string $icon = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): static
    {
        $this->link = $link;

        return $this;
    }

    public function getResource(): ?Resource
    {
        return $this->resource;
    }

    public function setResource(?Resource $resource): static
    {
        $this->resource = $resource;

        return $this;
    }

    public function getIcon(string $field = 'value'): ?string
    {
        if (null == SocialIconEnum::get($this->icon)) {
            return null;
        }

        return SocialIconEnum::get($this->icon)->$field;
    }

    public function setIcon(?string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }
}
