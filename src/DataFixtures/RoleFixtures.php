<?php

namespace App\DataFixtures;
use App\Entity\Role;
use App\Enum\Role\RoleEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RoleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $role = new Role();
        $role->setCode(RoleEnum::ROLE_ADMIN);
        $role->setLabel('Administrateur');
        $this->setReference( 'ROLE_ADMIN', $role );

        $manager->persist($role);
        $manager->flush();
    }
}
