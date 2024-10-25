<?php

namespace App\DataFixtures;

use App\Entity\Materiel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class MaterielFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $materielData = [
            [
                'nom' => 'Parapluie 3x4 m',
                'quantite' => 40,
                'prix' => 15,
                'image' => "parapluie.jpg"
            ],
            [
                'nom' => 'Table pliante 2 m',
                'quantite' => 90,
                'prix' => 0,
                'image' => "table-pliante.jpg"
            ],
            [
                'nom' => 'Table pliante 2,2 m',
                'quantite' => 350,
                'prix' => 0,
                'image' => "table2_2.jpg"
            ],
            [
                'nom' => 'Banc 2 m',
                'quantite' => 410,
                'prix' => 0,
                'image' => "banc2_m.jpg"
            ],
            [
                'nom' => 'Banc pliant 2,2 m',
                'quantite' => 780,
                'prix' => 0,
                'image' => "banc2_m.jpg"
            ],
            [
                'nom' => 'Tente pliante 4.5x3 m',
                'quantite' => 10,
                'prix' => 35,
                'image' => "tente-pliante4_5.jpg"
            ],
            [
                'nom' => 'Tente pliante 3x3 m',
                'quantite' => 30,
                'prix' => 25,
                'image' => "table-pliante.jpg"
            ],
            [
                'nom' => 'Tente pliante 6x3 m',
                'quantite' => 40,
                'prix' => 50,
                'image' => "tente-pliante6_3.jpg"
            ],
            [
                'nom' => 'Chauffe saucisses',
                'quantite' => 20,
                'prix' => 20,
                'image' => "chauffe-saucisse.jpg"
            ],
            [
                'nom' => 'Crêpière',
                'quantite' => 20,
                'prix' => 200,
                'image' => "crepière.jpg"
            ],
            [
                'nom' => 'Congélateur bahut 200 litres',
                'quantite' => 10,
                'prix' => 300,
                'image' => "congelateur.jpg"
            ],
            [
                'nom' => 'Mange-Debout',
                'quantite' => 60,
                'prix' => 5,
                'image' => "mange-debout.jpg"
            ],
            [
                'nom' => 'Remorque frigorifique 6m3',
                'quantite' => 10,
                'prix' => 100,
                'image' => "remorque-frigorifique.jpg"
            ]
        ];

        foreach ($materielData as $index => $data) {
            $materiel = new Materiel();
            $this->setReference('Materiel' . $index, $materiel);

            $materiel->setNomMateriel($data['nom']);
            $materiel->setImageMateriel($data['image']);
            $materiel->setDescriptionMateriel('Description pour ' . $data['nom']);
            $materiel->setPrixMateriel(is_numeric($data['prix']) ? $data['prix'] : 0);
            $materiel->setNombreExemplaireMateriel($data['quantite']);
            $materiel->setArchiver(false);
            $materiel->setCreatedAt(new \DateTime());
            $materiel->setUpdatedAt(new \DateTime());
            $manager->persist($materiel);
        }
        $manager->flush();
    }

}