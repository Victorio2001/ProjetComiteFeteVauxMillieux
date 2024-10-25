<?php

namespace App\DataFixtures;

use App\Entity\Photo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PhotoFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($count = 0; $count < 20; $count++) {
            $photo = new Photo();
            $photo->setTitreImage("PhotoDefault.png");
            $photo->setDescriptionImage($faker->paragraph());
            $photo->setDateImage($faker->dateTimeBetween('-1 years', 'now'));
            $photo->setCreatedAt($faker->dateTimeBetween('-2 years', 'now'));
            $photo->setUpdatedAt($faker->dateTimeBetween('-1 years', 'now'));

            $manager->persist($photo);
            $this->addReference('photo_'.$count, $photo);
        }

        $manager->flush();
    }
}
