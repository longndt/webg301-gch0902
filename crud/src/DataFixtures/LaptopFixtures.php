<?php

namespace App\DataFixtures;

use App\Entity\Laptop;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LaptopFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=20; $i++) {
            $laptop = new Laptop;
            $laptop->setName("Laptop $i");
            $laptop->setBrand("Dell");
            $laptop->setColor("Silver");
            $laptop->setYear(rand(2012, 2022));
            $laptop->setPrice(1000);
            $manager->persist($laptop);
        }
        $manager->flush();
    }
}
