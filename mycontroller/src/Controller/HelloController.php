<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
   #[Route('/', name: 'index')]
   public function homepage() {
       return $this->render("hello/index.html");
   }

    /**
    * @Route("/greenwich", name = "greenwich")
    */
    public function greenwich() {
        return $this->render("hello/greenwich.html");
    }
}
