<?php

namespace App\Entity;

use AllowDynamicProperties;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[AllowDynamicProperties] #[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]

/* API-PLATFORM */
#[ApiResource(
    //https://api-platform.com/docs/core/operations/
    operations: [
        new GetCollection(
            description: 'Route affichant tout nos utilisateurs'
        ), //GetAll
        new Get(
            description: 'Route affichant utilisateur selon leur Id'
        ),//GetById
        new Post(
            description: 'Route Permettant de créer nos users'
        ), //Create
        new Put(
            description: 'Route Permettant de modifier nos users'
        ), //Update
        new Patch(
            description: 'Route Permettant de modifier un attribut de nôtre user'
        ), //UpdateOneByOne
        new Delete(
            description: 'Route Permettant de modifier un attribut de nôtre user'
        ), //UpdateOneByOne
    ]
)]
/*API-PLATFORM*/

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $avatar = null;

    #[ORM\Column]
    private bool $isVerified = false;

    /**
     * @var Collection<int, Role>
     */
    #[ORM\ManyToMany(targetEntity: Role::class)]
    private Collection $roles;

    /**
     * @var Collection<int, Reservation>
     */
    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'Utilisateur')]
    private Collection $reservations;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        return array_unique(
            array_map(
                static fn (Role $role): string => $role->getCode()->value,
                $this->roles->toArray()
            )
        );
    }



    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {

        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): static
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }


    //https://symfony.com/doc/current/components/options_resolver.html
    //https://symfony.com/doc/current/components/options_resolver.html
    public function __construct(array $options = [])
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);

        $resolvedOptions = $resolver->resolve($options);

        $this->prenom = $resolvedOptions['prenom'];
        $this->nom = $resolvedOptions['nom'];
        $this->isVerified = $resolvedOptions['isVerified'];
        $this->avatar = $resolvedOptions['avatar'];
        $this->roles = new ArrayCollection();
        $this->reservations = new ArrayCollection();

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'prenom'       => 'UserLastNameDefaulf',
            'nom'       => 'UserLastNameDefaulf',
            'isVerified'   => false,
            'avatar'   => 'DefaultImageMateriel.jpeg',
        ]);

        $resolver->setNormalizer('prenom', function ($options, $value) {
            return substr(strtoupper($value), 0, 50);
        });
        $resolver->setNormalizer('nom', function ($options, $value) {
            return substr(strtolower($value), 0, 50);
        });
        $resolver->setNormalizer('avatar', function ($options, $value) {
            return substr(strtolower($value), 0, 250);
        });

        $TypeBooool = [true, false];
        $resolver->setAllowedValues('isVerified', function ($value) use ($TypeBooool) {
            return in_array($value, $TypeBooool, true);
        });

        $resolver->setAllowedTypes('prenom', 'string');
        $resolver->setAllowedTypes('avatar', 'string');
        $resolver->setAllowedTypes('avatar', 'string');
        $resolver->setAllowedTypes('isVerified', 'bool');

    }

    public function addRole(Role $role): static
    {
        if (!$this->roles->contains($role)) {
            $this->roles->add($role);
        }

        return $this;
    }

    public function removeRole(Role $role): static
    {
        $this->roles->removeElement($role);

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setUtilisateur($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {

            if ($reservation->getUtilisateur() === $this) {
                $reservation->setUtilisateur(null);
            }
        }

        return $this;
    }
}
