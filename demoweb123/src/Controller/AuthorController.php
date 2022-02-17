<?php

namespace App\Controller;

use App\Entity\Author;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/author')]
class AuthorController extends AbstractController
{
    #[Route('', name: 'author_index')]
    public function authorIndex () {
        //B1: lấy dữ liệu từ database
        //SELECT * FROM author
        $author = $this->getDoctrine()->getRepository(Author::class)->findAll();
        //B2: render ra view và gửi kèm dữ liệu
        return $this->render("author/index.html.twig",
            [
                'authors' => $author
            ]);
    }

    #[Route('/detail/{id}', name: 'author_detail')]
    public function authorDetail ($id) {
        //SELECT * FROM author WHERE id = '$id'
        $author = $this->getDoctrine()->getRepository(Author::class)->find($id);
        if ($author == null) {
            $this->addFlash("Error","Author not found !");
            return $this->redirectToRoute("author_index");
        }
        return $this->render("author/detail.html.twig",
            [
                'author' => $author
            ]);
    }

    #[Route('/delete/{id}', name: 'author_delete')]
    public function authorDelete ($id) {
        //DELETE FROM author WHERE id = '$id'
        $author = $this->getDoctrine()->getRepository(Author::class)->find($id);
        //check xem author có tồn tại trong db hay không
        if ($author == null) {
            //gửi flash message từ controller đến view
            $this->addFlash("Error","Author not found !");
        } else {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($author);
            $manager->flush();
            $this->addFlash("Success","Delete author succeed !");
        }
        return $this->redirectToRoute("author_index");
    }
}

