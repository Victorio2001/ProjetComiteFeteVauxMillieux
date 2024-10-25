<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MaterielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MaterielRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['Materiel']],
    denormalizationContext: ['groups' => ['Materiel', 'Materiel:write']],
)]
class Materiel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("Materiel")]
    private ?int $id = null;

    #[Groups("Materiel")]
    #[ORM\Column(length: 255)]
    private ?string $nomMateriel = null;

    #[Groups("Materiel")]
    #[ORM\Column(length: 255)]
    private ?string $imageMateriel = null;

    #[Groups("Materiel")]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $descriptionMateriel = null;
    #[Groups("Materiel")]
    #[ORM\Column]
    private ?int $prixMateriel = null;
    #[Groups("Materiel")]
    #[ORM\Column]
    private ?int $nombreExemplaireMateriel = null;
    #[Groups("Materiel")]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;
    #[Groups("Materiel")]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updated_at = null;

    /**
     * @var Collection<int, MaterielReservation>
     */
    #[Groups("Materiel")]
    #[ORM\OneToMany(targetEntity: MaterielReservation::class, mappedBy: 'materiel')]
    private Collection $MaterielReservation;

    #[ORM\Column(nullable: true)]
    private ?bool $archiver = null;

    public function __construct()
    {
        $this->MaterielReservation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomMateriel(): ?string
    {
        return $this->nomMateriel;
    }

    public function setNomMateriel(string $nomMateriel): static
    {
        $this->nomMateriel = $nomMateriel;

        return $this;
    }

    public function getImageMateriel(): ?string
    {
        return $this->imageMateriel;
    }

    public function setImageMateriel(string $imageMateriel): static
    {
        $this->imageMateriel = $imageMateriel;

        return $this;
    }

    public function getDescriptionMateriel(): ?string
    {
        return $this->descriptionMateriel;
    }

    public function setDescriptionMateriel(string $descriptionMateriel): static
    {
        $this->descriptionMateriel = $descriptionMateriel;

        return $this;
    }

    public function getPrixMateriel(): ?int
    {
        return $this->prixMateriel;
    }

    public function setPrixMateriel(int $prixMateriel): static
    {
        $this->prixMateriel = $prixMateriel;

        return $this;
    }

    public function getNombreExemplaireMateriel(): ?int
    {
        return $this->nombreExemplaireMateriel;
    }

    public function setNombreExemplaireMateriel(int $nombreExemplaireMateriel): static
    {
        $this->nombreExemplaireMateriel = $nombreExemplaireMateriel;

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
     * @return Collection<int, MaterielReservation>
     */
    public function getMaterielReservation(): Collection
    {
        return $this->MaterielReservation;
    }

    public function addMaterielReservation(MaterielReservation $materielReservation): static
    {
        if (!$this->MaterielReservation->contains($materielReservation)) {
            $this->MaterielReservation->add($materielReservation);
            $materielReservation->setMateriel($this);
        }

        return $this;
    }

    public function removeMaterielReservation(MaterielReservation $materielReservation): static
    {
        if ($this->MaterielReservation->removeElement($materielReservation)) {
            // set the owning side to null (unless already changed)
            if ($materielReservation->getMateriel() === $this) {
                $materielReservation->setMateriel(null);
            }
        }

        return $this;
    }

    public function isArchiver(): ?bool
    {
        return $this->archiver;
    }

    public function setArchiver(?bool $archiver): static
    {
        $this->archiver = $archiver;

        return $this;
    }
}
