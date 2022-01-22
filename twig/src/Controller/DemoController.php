<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemoController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home() {
        $text = "Tet holiday is coming";
        $number = 2022;
        $name = array("Minh", "Tien", "Nam", "Hoang");
        return $this->render("demo/index.html.twig",
                            [
                                'string' => $text,
                                'integer' => $number,
                                'array' => $name  
                            ]);
    }

}
