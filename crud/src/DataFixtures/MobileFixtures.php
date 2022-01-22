<?php

namespace App\DataFixtures;

use App\Entity\Mobile;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MobileFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<10; $i++) {
            $mobile = new Mobile;
            $mobile->setName("iPhone 13 Pro Max");
            $mobile->setPrice(1234.56);
            $mobile->setDate(\DateTime::createFromFormat('Y-m-d','2022-01-15'));
            $manager->persist($mobile);
        }

        $manager->flush();
    }
}
