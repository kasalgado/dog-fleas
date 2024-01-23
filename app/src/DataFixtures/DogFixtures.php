<?php

namespace App\DataFixtures;

use App\Entity\Dog;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DogFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $dog = new Dog();
            $dog->setAge(mt_rand(1, 10));
            $dog->setName('Dog' . $i);

            $manager->persist($dog);
        }

        $manager->flush();
    }
}