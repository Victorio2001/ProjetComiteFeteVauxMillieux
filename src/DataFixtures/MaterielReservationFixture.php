<?php

namespace App\DataFixtures;

use App\Entity\Materiel;
use App\Entity\MaterielReservation;
use App\Entity\Reservation;
use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class MaterielReservationFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $fakerFactory = Factory::create('fr_FR');

        for ($count = 0; $count < 12; $count++) {

            $MaterielRes = new MaterielReservation();

            $MaterielRes->setReservation(  $this->getReference(
                'Reservation'.$count,
                Reservation::class
            ));
            $MaterielRes->setMateriel(  $this->getReference(
                'Materiel'.$count,
                Materiel::class
            ));
            $MaterielRes->setQuantiteReservation($fakerFactory->numberBetween($min = 10, $max = 800));
            $MaterielRes->setPrixOrigine($fakerFactory->numberBetween($min = 10, $max = 800));
            $manager->persist($MaterielRes);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ReservationFixture::class,
            MaterielFixture::class,
        ];
    }

}
