<?php

namespace App\DataFixtures;
use App\Entity\Reservation;
use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ReservationFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        $fakerFactory = Factory::create('fr_FR');
        for ($count = 0; $count < 25; $count++) {

            $Reservation = new Reservation();
            $this->setReference( 'Reservation'.$count, $Reservation );

            $Reservation->setDateRetour($fakerFactory->dateTimeBetween());
            $Reservation->setDateEmprunt($fakerFactory->dateTimeBetween());
            $Reservation->setDateReservation($fakerFactory->dateTimeBetween());
            $Reservation->setArchiverReservation($fakerFactory->boolean());
            // En-cours, Archivé, Annulé, En attente, terminer
            $Reservation->setEtat("En attente");

            $Reservation->setMailReservation($fakerFactory->email());
            $Reservation->setNomAsso("association");
            $Reservation->setPrenomUserReservation($fakerFactory->name());
            $Reservation->setNomUserReservation($fakerFactory->lastName());
            $Reservation->setNumeroReservant(060261);

            $Reservation->setCommentaireReservation($fakerFactory->realText());
            $Reservation->setUpdatedAt($fakerFactory->dateTimeBetween());
            $Reservation->setCreatedAt($fakerFactory->dateTimeBetween());
            $Reservation->setUtilisateur(
                $this->getReference(
                    'UtilisateurReservation',
                    User::class
                )
            );
            $manager->persist($Reservation);
        }
        $manager->flush();
    }
    public function getDependencies(): array
    {
    return[
        UserFixture::class
    ];
    }
}
