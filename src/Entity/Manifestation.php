<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ManifestationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ManifestationRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['manifestation:read']],
    denormalizationContext: ['groups' => ['manifestation:write']]
)]
class Manifestation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['manifestation:read', 'manifestation:write'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['manifestation:read', 'manifestation:write'])]
    private ?string $titreManifestation = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['manifestation:read', 'manifestation:write'])]
    private ?string $descriptionManifestation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['manifestation:read', 'manifestation:write'])]
    private ?\DateTimeInterface $dateDebutManifestation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['manifestation:read', 'manifestation:write'])]
    private ?\DateTimeInterface $dateFinManifestation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['manifestation:read', 'manifestation:write'])]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['manifestation:read', 'manifestation:write'])]
    private ?\DateTimeInterface $updated_at = null;

    

    /**
     * @var Collection<int, Photo>
     */
    #[ORM\OneToMany(mappedBy: 'Manifestation', targetEntity: Photo::class, cascade: ['persist', 'remove'])]
    private Collection $photos;
    

    #[ORM\OneToMany(mappedBy: 'manifestation', targetEntity: Lier::class, orphanRemoval: true)]
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

    public function getTitreManifestation(): ?string
    {
        return $this->titreManifestation;
    }

    public function setTitreManifestation(string $titreManifestation): static
    {
        $this->titreManifestation = $titreManifestation;
        return $this;
    }

    public function getDescriptionManifestation(): ?string
    {
        return $this->descriptionManifestation;
    }

    public function setDescriptionManifestation(string $descriptionManifestation): static
    {
        $this->descriptionManifestation = $descriptionManifestation;
        return $this;
    }

    public function getDateDebutManifestation(): ?\DateTimeInterface
    {
        return $this->dateDebutManifestation;
    }

    public function setDateDebutManifestation(\DateTimeInterface $dateDebutManifestation): static
    {
        $this->dateDebutManifestation = $dateDebutManifestation;
        return $this;
    }

    public function getDateFinManifestation(): ?\DateTimeInterface
    {
        return $this->dateFinManifestation;
    }

    public function setDateFinManifestation(\DateTimeInterface $dateFinManifestation): static
    {
        $this->dateFinManifestation = $dateFinManifestation;
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
            $photo->setManifestation($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): static
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getManifestation() === $this) {
                $photo->setManifestation(null);
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
            $lier->setManifestation($this);
        }

        return $this;
    }

    public function removeLier(Lier $lier)
    {
        if ($this->liers->removeElement($lier)) {
            // set the owning side to null (unless already changed)
            if ($lier->getManifestation() === $this) {
                $lier->setManifestation(null);
            }
        }
    }

}
