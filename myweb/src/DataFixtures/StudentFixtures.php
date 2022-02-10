<?php

namespace App\DataFixtures;

use App\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StudentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=5; $i++) {
            $student = new Student;
            $student->setSid('GCH11111 ' . '$i');
            $student->setSname('Student ' . '$i');
            $student->setSgrade((float)(rand(5,9)));
            $student->setSdob(\DateTime::createFromFormat('Y/m/d','1998/06/09'));
            $manager->persist($student);
        }
        $manager->flush();
    }
}
