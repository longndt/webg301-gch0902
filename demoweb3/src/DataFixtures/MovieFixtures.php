<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MovieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=10; $i++) {
            $movie = new Movie;
            $movie->setName("Movie $i");
            $movie->setYear(rand(2000,2022));
            $movie->setImage("https://nbcpalmsprings.com/wp-content/uploads/sites/8/2021/12/BEST-MOVIES-OF-2021.jpeg");
            $manager->persist($movie);
        }

        $manager->flush();
    }
}
