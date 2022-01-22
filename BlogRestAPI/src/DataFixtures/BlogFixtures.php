<?php

namespace App\DataFixtures;

use App\Entity\Blog;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BlogFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=10; $i++) {
            $blog = new Blog;
            $blog->setTitle("Blog $i");
            $blog->setAuthor("Tien Hung");
            $blog->setDate(\DateTime::createFromFormat('Y-m-d','2022-01-20'));
            $blog->setContent("Hello everyone. This is my first blog.");
            $manager->persist($blog);
        }
        $manager->flush();
    }
}
