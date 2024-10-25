<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MaterielReservationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MaterielReservationRepository::class)]
#[ApiResource]
class MaterielReservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantiteReservation = null;

    #[ORM\Column]
    private ?float $prixOrigine = null;

    #[ORM\ManyToOne(inversedBy: 'MaterielReservation')]
    private ?Materiel $materiel = null;

    #[ORM\ManyToOne(inversedBy: 'MaterielReservation', cascade: ['persist'])]
    private ?Reservation $reservation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantiteReservation(): ?int
    {
        return $this->quantiteReservation;
    }

    public function setQuantiteReservation(int $quantiteReservation): static
    {
        $this->quantiteReservation = $quantiteReservation;

        return $this;
    }

    public function getPrixOrigine(): ?float
    {
        return $this->prixOrigine;
    }

    public function setPrixOrigine(float $prixOrigine): static
    {
        $this->prixOrigine = $prixOrigine;

        return $this;
    }

    public function getMateriel(): ?Materiel
    {
        return $this->materiel;
    }

    public function setMateriel(?Materiel $materiel): static
    {
        $this->materiel = $materiel;

        return $this;
    }

    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }

    public function setReservation(?Reservation $reservation): static
    {
        $this->reservation = $reservation;

        return $this;
    }
}
