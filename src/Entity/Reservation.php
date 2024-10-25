<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Controller\Reservation\CreateApi\ReservationCreateControllerApi;
use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['Reservation']],
    denormalizationContext: ['groups' => ['Reservation', 'Reservation:write']],
    operations: [
        new GetCollection(),
        new Post(
            controller: ReservationCreateControllerApi::class,
            deserialize: true,
            serialize: true,
            openapiContext: [
                'requestBody' => [
                    'content' => [
                        'application/ld+json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'dateReservation' => ['type' => 'string', 'format' => 'date-time'],
                                    'commentaireReservation' => ['type' => 'string'],
                                    'etat' => ['type' => 'string'],
                                    'archiverReservation' => ['type' => 'boolean'],
                                    'dateRetour' => ['type' => 'string', 'format' => 'date-time'],
                                    'dateEmprunt' => ['type' => 'string', 'format' => 'date-time'],
                                    'created_at' => ['type' => 'string', 'format' => 'date-time'],
                                    'updated_at' => ['type' => 'string', 'format' => 'date-time'],
                                    'Utilisateur' => ['type' => 'string', 'format' => 'iri-reference'],
                                    'mailReservation' => ['type' => 'string'],
                                    'nomAsso' => ['type' => 'string'],
                                    'nomUserReservation' => ['type' => 'string'],
                                    'prenomUserReservation' => ['type' => 'string'],
                                    'numeroReservant' => ['type' => 'integer'],
                                    'MaterielReservation' => [
                                        'type' => 'array',
                                        'items' => [
                                            'type' => 'object',
                                            'properties' => [
                                                'quantiteReservation' => ['type' => 'integer'],
                                                'prixOrigine' => ['type' => 'number'],
                                                'materiel' => ['type' => 'string', 'format' => 'iri-reference']
                                            ]
                                        ]
                                    ]
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        ),
    ]
)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateReservation = null;

    #[ORM\Column(type: 'boolean', nullable: false)]
    private ?bool $archiverReservation = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $commentaireReservation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateRetour = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateEmprunt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $Utilisateur = null;

    /**
     * @var Collection<int, MaterielReservation>
     */
    #[ORM\OneToMany(targetEntity: MaterielReservation::class, mappedBy: 'reservation', cascade: ['persist', 'remove'])]
    private Collection $MaterielReservation;

    #[ORM\Column(length: 255)]
    private ?string $etat = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mailReservation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nomAsso = null;



    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nomUserReservation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prenomUserReservation = null;

    #[ORM\Column(nullable: true)]
    private ?int $numeroReservant = null;

    public function __construct()
    {
        $this->MaterielReservation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateReservation(): ?\DateTimeInterface
    {
        return $this->dateReservation;
    }

    public function setDateReservation(\DateTimeInterface $dateReservation): static
    {
        $this->dateReservation = $dateReservation;

        return $this;
    }

    public function isArchiverReservation(): ?bool
    {
        return $this->archiverReservation;
    }

    public function setArchiverReservation(bool $archiverReservation): static
    {
        $this->archiverReservation = $archiverReservation;

        return $this;
    }

    public function getArchiverReservation(): ?bool
    {
        return $this->archiverReservation;
    }

    public function getCommentaireReservation(): ?string
    {
        return $this->commentaireReservation;
    }

    public function setCommentaireReservation(string $commentaireReservation): static
    {
        $this->commentaireReservation = $commentaireReservation;

        return $this;
    }

    public function getDateRetour(): ?\DateTimeInterface
    {
        return $this->dateRetour;
    }

    public function setDateRetour(\DateTimeInterface $dateRetour): static
    {
        $this->dateRetour = $dateRetour;

        return $this;
    }

    public function getDateEmprunt(): ?\DateTimeInterface
    {
        return $this->dateEmprunt;
    }

    public function setDateEmprunt(\DateTimeInterface $dateEmprunt): static
    {
        $this->dateEmprunt = $dateEmprunt;

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

    public function getUtilisateur(): ?User
    {
        return $this->Utilisateur;
    }

    public function setUtilisateur(?User $Utilisateur): static
    {
        $this->Utilisateur = $Utilisateur;

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
            $materielReservation->setReservation($this);
        }

        return $this;
    }

    public function removeMaterielReservation(MaterielReservation $materielReservation): static
    {
        if ($this->MaterielReservation->removeElement($materielReservation)) {
            if ($materielReservation->getReservation() === $this) {
                $materielReservation->setReservation(null);
            }
        }

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getMailReservation(): ?string
    {
        return $this->mailReservation;
    }

    public function setMailReservation(?string $mailReservation): static
    {
        $this->mailReservation = $mailReservation;

        return $this;
    }

    public function getNomAsso(): ?string
    {
        return $this->nomAsso;
    }

    public function setNomAsso(?string $nomAsso): static
    {
        $this->nomAsso = $nomAsso;

        return $this;
    }

    public function getNomUserReservation(): ?string
    {
        return $this->nomUserReservation;
    }

    public function setNomUserReservation(?string $nomUserReservation): static
    {
        $this->nomUserReservation = $nomUserReservation;

        return $this;
    }

    public function getPrenomUserReservation(): ?string
    {
        return $this->prenomUserReservation;
    }

    public function setPrenomUserReservation(?string $prenomUserReservation): static
    {
        $this->prenomUserReservation = $prenomUserReservation;

        return $this;
    }

    public function getNumeroReservant(): ?int
    {
        return $this->numeroReservant;
    }

    public function setNumeroReservant(?int $numeroReservant): static
    {
        $this->numeroReservant = $numeroReservant;

        return $this;
    }
}
