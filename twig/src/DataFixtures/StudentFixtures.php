<?php

namespace App\DataFixtures;

use App\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StudentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=10; $i++) {
            $student = new Student;
            $student->setName("Student $i");
            $student->setDob(\DateTime::createFromFormat('Y-m-d','1996-06-08'));
            $student->setMobile("0912345678");
            $student->setAddress("Ha Noi");
            $manager->persist($student);
        }

        $manager->flush();
    }
}
