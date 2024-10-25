<?php

namespace App\DataFixtures;

use App\Entity\Manifestation;
use App\Entity\Photo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class ManifestationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $startOfJuly = new \DateTime('2024-07-01');
        $endOfJuly = new \DateTime('2024-07-31');

        $occupiedPeriods = [];

        for ($count = 0; $count < 10; $count++) {
            $manifestation = new Manifestation();
            $manifestation->setTitreManifestation($faker->sentence());
            $manifestation->setDescriptionManifestation($faker->paragraph());

            do {
                $dateDebutManifestation = $faker->dateTimeBetween($startOfJuly, $endOfJuly);
                $dateFinManifestation = (clone $dateDebutManifestation)->modify('+1 day');
            } while ($this->checkOverlap($dateDebutManifestation, $dateFinManifestation, $occupiedPeriods));

            $occupiedPeriods[] = [$dateDebutManifestation, $dateFinManifestation];

            $manifestation->setDateDebutManifestation($dateDebutManifestation);
            $manifestation->setDateFinManifestation($dateFinManifestation);
            $manifestation->setCreatedAt($faker->dateTimeBetween('-2 years', 'now'));
            $manifestation->setUpdatedAt($faker->dateTimeBetween('-1 years', 'now'));

            for ($photoCount = 0; $photoCount < rand(1, 3); $photoCount++) {
                /** @var Photo $photo */
                $photo = $this->getReference('photo_' . rand(0, 19));
                $manifestation->addPhoto($photo);
            }
            $manager->persist($manifestation);
            $this->addReference('manifestation_' . $count, $manifestation);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            PhotoFixtures::class,
        ];
    }

    private function checkOverlap($start, $end, $occupiedPeriods)
    {
        foreach ($occupiedPeriods as $period) {
            if (($start >= $period[0] && $start <= $period[1]) || ($end >= $period[0] && $end <= $period[1]) || ($start <= $period[0] && $end >= $period[1])) {
                return true;
            }
        }
        return false;
    }
}
