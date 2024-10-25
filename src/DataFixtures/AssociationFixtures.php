<?php

namespace App\DataFixtures;

use App\Entity\Association;
use App\Entity\Photo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class AssociationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 20; $i++) {
            $association = new Association();
            $association->setNomAssociation($faker->company);
            $association->setDescriptionAssociation($faker->paragraph);
            $association->setCreatedAt(new \DateTimeImmutable());
            $association->setUpdatedAt(new \DateTimeImmutable());

            $manager->persist($association);
            $this->addReference('association_' . $i, $association);
            $association->addPhoto(
                $this->getReference(
                    'photo_' . $i,
                    Photo::class
                )
            );
        }
        
        
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            PhotoFixtures::class
        ];
    }
}
