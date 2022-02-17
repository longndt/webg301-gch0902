<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AuthorFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=10; $i++) {
            $author = new Author;
            $author->setName("Author $i");
            $author->setNationality("Vietnam");
            $author->setBirthday(\DateTime::createFromFormat('Y/m/d','1990/05/10'));
            $manager->persist($author);
        }

        $manager->flush();
    }
}
