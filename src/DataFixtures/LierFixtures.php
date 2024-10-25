<?php

namespace App\DataFixtures;

use App\Entity\Lier;
use App\Entity\Manifestation;
use App\Entity\Association;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class LierFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        
        for ($i = 0; $i < 10; $i++) {
            $manifestation = $this->getReference('manifestation_'.$i);
            $association = $this->getReference('association_'.$i);

            $lier = new Lier();
            $lier->setManifestation($manifestation);
            $lier->setAssociation($association);

            $manager->persist($lier);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ManifestationFixtures::class,
            AssociationFixtures::class,
        ];
    }
}
