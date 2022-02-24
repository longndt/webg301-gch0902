<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=20; $i++) {
            $book = new Book;
            $book->setTitle("Programming $i");
            $book->setPrice((float)(rand(10,50)));
            $book->setYear(rand(2010, 2022));
            $book->setImage("book.jpg");
            $manager->persist($book);
        }

        $manager->flush();
    }
}
