<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ApiResource(
    normalizationContext: ['groups' => ['lier:read']],
    denormalizationContext: ['groups' => ['lier:write']]
)]
class Lier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['lier:read', 'lier:write'])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Manifestation::class, inversedBy: 'liers')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[Groups(['lier:read', 'lier:write'])]
    private ?Manifestation $manifestation = null;

    #[ORM\ManyToOne(targetEntity: Association::class, inversedBy: 'liers')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[Groups(['lier:read', 'lier:write'])]
    private ?Association $association = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getManifestation(): ?Manifestation
    {
        return $this->manifestation;
    }

    public function setManifestation(?Manifestation $manifestation): static
    {
        $this->manifestation = $manifestation;

        return $this;
    }

    public function getAssociation(): ?Association
    {
        return $this->association;
    }

    public function setAssociation(?Association $association): static
    {
        $this->association = $association;

        return $this;
    }
}
