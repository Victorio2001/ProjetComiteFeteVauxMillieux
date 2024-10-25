<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ContactFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $fakerFactory = Factory::create(locale: 'fr_FR');//données aléatoires

        for ($i =0; $i < 20; ++$i){
            $myContact = new Contact();
            $myContact->setEmail($fakerFactory->email());
            $myContact->setObjet($fakerFactory->text());
            $myContact->setCommentaire($fakerFactory->realText());
            $myContact->setCreateAt($fakerFactory->dateTimeBetween());
            $myContact->setUpdateAt($fakerFactory->dateTimeBetween());
            $myContact->setEtatcontact($fakerFactory->boolean());


            $manager->persist($myContact);//nouvelles entitées
        }

        $manager->flush();//permet d'executer en base
    }
}
