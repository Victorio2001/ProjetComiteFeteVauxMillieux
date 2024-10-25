<?php

namespace App\Entity;

use App\Repository\AssociationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AssociationRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['association:read']],
    denormalizationContext: ['groups' => ['association:write']]
)]
class Association
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['association:read', 'association:write'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['association:read', 'association:write'])]
    private ?string $nomAssociation = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['association:read', 'association:write'])]
    private ?string $descriptionAssociation = null;

    #[ORM\Column]
    #[Groups(['association:read', 'association:write'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['association:read', 'association:write'])]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, Photo>
     */
    #[ORM\OneToMany(mappedBy: 'Association', targetEntity: Photo::class, cascade: ['persist', 'remove'])]
    private Collection $photos;
    

    #[ORM\OneToMany(mappedBy: 'association', targetEntity: Lier::class, orphanRemoval: true)]
    private Collection $liers;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
        $this->liers = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomAssociation(): ?string
    {
        return $this->nomAssociation;
    }

    public function setNomAssociation(string $nomAssociation): static
    {
        $this->nomAssociation = $nomAssociation;
        return $this;
    }

    public function getDescriptionAssociation(): ?string
    {
        return $this->descriptionAssociation;
    }

    public function setDescriptionAssociation(string $descriptionAssociation): static
    {
        $this->descriptionAssociation = $descriptionAssociation;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return Collection<int, Photo>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): static
    {
        if (!$this->photos->contains($photo)) {
            $this->photos->add($photo);
            $photo->setAssociation($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): static
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getAssociation() === $this) {
                $photo->setAssociation(null);
            }
        }

        return $this;
    }
    
    public function getLiers(): Collection
    {
        return $this->liers;
    }

    public function addLier(Lier $lier): static
    {
        if (!$this->liers->contains($lier)) {
            $this->liers->add($lier);
            $lier->setAssociation($this);
        }

        return $this;
    }

    public function removeLier(Lier $lier)
    {
        if ($this->liers->removeElement($lier)) {
            // set the owning side to null (unless already changed)
            if ($lier->getAssociation() === $this) {
                $lier->setAssociation(null);
            }
        }
    }
}
