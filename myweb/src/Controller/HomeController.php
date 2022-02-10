<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        $university = "Greenwich Vietnam";
        $semester = "Spring 2022";
        $module = "Project Web";
        $mobiles = array("iPhone","Samsung","Oppo", "HTC", "Xiaomi");

        return $this->render('home/index.html.twig',
            [
                'university' => $university,
                'semester' => $semester,
                'module' => $module,
                'mobiles' => $mobiles
            ]
    );
    }
}
