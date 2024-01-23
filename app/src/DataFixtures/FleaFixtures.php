<?php


namespace App\DataFixtures;

use App\Entity\Flea;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FleaFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Create 20 fleas with random data
        for ($i = 0; $i < 20; $i++) {
            $flea = new Flea();
            // Timestamp will be set automatically in the constructor

            $manager->persist($flea);
        }

        $manager->flush();
    }
}