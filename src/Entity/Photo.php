<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ApiResource(
    normalizationContext: ['groups' => ['photo:read']],
    denormalizationContext: ['groups' => ['photo:write']]
)]
class Photo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['photo:read', 'photo:write', 'manifestation:read', 'association:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['photo:read', 'photo:write', 'manifestation:read', 'association:read'])]
    private ?string $titreImage = null;

    #[ORM\Column(type: 'text')]
    #[Groups(['photo:read', 'photo:write', 'manifestation:read', 'association:read'])]
    private ?string $descriptionImage = null;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['photo:read', 'photo:write', 'manifestation:read', 'association:read'])]
    private ?\DateTimeInterface $dateImage = null;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['photo:read', 'photo:write', 'manifestation:read', 'association:read'])]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['photo:read', 'photo:write', 'manifestation:read', 'association:read'])]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\ManyToOne(inversedBy: 'photos', cascade: ['persist', 'remove'])]
    private ?Association $Association = null;

    #[ORM\ManyToOne(inversedBy: 'photos', cascade: ['persist', 'remove'])]
    private ?Manifestation $Manifestation = null;
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreImage(): ?string
    {
        return $this->titreImage;
    }

    public function setTitreImage(string $titreImage): static
    {
        $this->titreImage = $titreImage;
        return $this;
    }

    public function getDescriptionImage(): ?string
    {
        return $this->descriptionImage;
    }

    public function setDescriptionImage(string $descriptionImage): static
    {
        $this->descriptionImage = $descriptionImage;
        return $this;
    }

    public function getDateImage(): ?\DateTimeInterface
    {
        return $this->dateImage;
    }

    public function setDateImage(\DateTimeInterface $dateImage): static
    {
        $this->dateImage = $dateImage;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): static
    {
        $this->created_at = $created_at;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): static
    {
        $this->updated_at = $updated_at;
        return $this;
    }

    public function getAssociation(): ?Association
    {
        return $this->Association;
    }

    public function setAssociation(?Association $Association): static
    {
        $this->Association = $Association;

        return $this;
    }

    public function getManifestation(): ?Manifestation
    {
        return $this->Manifestation;
    }

    public function setManifestation(?Manifestation $Manifestation): static
    {
        $this->Manifestation = $Manifestation;

        return $this;
    }
}
