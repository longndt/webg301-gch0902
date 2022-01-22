<?php

namespace App\Controller;

use App\Entity\Student;
use PHPUnit\Framework\MockObject\Builder\Stub;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
   #[Route("/student", name: "student_list")]
   public function studentList() {
       $students = $this->getDoctrine()->getRepository(Student::class)->findAll();
       return $this->render("student/index.html.twig",
                            [
                                'students' => $students
                            ]
                            );
   }

   #[Route("/student/{id}", name: "student_detail")]
   public function studentDetail($id) {
       $student = $this->getDoctrine()->getRepository(Student::class)->find($id);
       return $this->render("student/detail.html.twig",
                            [
                                'student' => $student
                            ]
                            );
   }
}
