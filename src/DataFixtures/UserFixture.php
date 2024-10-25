<?php

namespace App\DataFixtures;
use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture implements DependentFixtureInterface
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();


        $user->setNom('Goudet');
        $user->setAvatar('DefaultImageMateriel.jpeg');
        $user->setPrenom('Magalie');
        $user->setEmail('Goudet@gmail.com');
        $user->setVerified(true);
        $user->addRole(
            $this->getReference(
                'ROLE_ADMIN',
                Role::class
            )
        );
        $user->setPassword($this->passwordHasher->hashPassword(
            $user,
            'root'
        ));
        $manager->persist($user);



        $fakerFactory = Factory::create('fr_FR');

        for ($count = 0; $count < 5; $count++) {

            $user = new User();
            $this->setReference( 'UtilisateurReservation', $user );
            $user->setNom($fakerFactory->firstName());
            $user->setAvatar('DefaultImageMateriel.jpeg');
            $user->setPrenom($fakerFactory->lastName());
            $user->setEmail($fakerFactory->email());
            $user->setVerified(true);
            $user->addRole(
                $this->getReference(
                    'ROLE_ADMIN',
                    Role::class
                )
            );
            $user->setPassword($this->passwordHasher->hashPassword(
                $user,
                'root'
            ));
            $manager->persist($user);
        }
        $manager->flush();
    }
    public function getDependencies(): array
    {
    return[
        RoleFixtures::class
    ];
    }
}
