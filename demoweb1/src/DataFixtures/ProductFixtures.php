<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=10; $i++) {
            $product = new Product;
            $product->setName("Product " . "$i");
            $product->setQuantity(rand(10,30));
            $product->setPrice((float)(rand(1000,2000)));
            $manager->persist($product);
        }

        $manager->flush();
    }
}
