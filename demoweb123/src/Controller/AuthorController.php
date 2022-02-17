<?php

namespace App\Controller;

use App\Entity\Author;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/author')]
class AuthorController extends AbstractController
{
    #[Route('', name: 'author_index')]
    public function viewAuthorList () {
        $author = $this->getDoctrine()->getRepository(Author::class)->findAll();
        return $this->render("author/index.html.twig",
        [
            'authors' => $author
        ]);
    }

    #[Route('/detail/{id}', name: 'author_detail')]
    public function viewAuthorById ($id) {
        $author = $this->getDoctrine()->getRepository(Author::class)->find($id);
        return $this->render("author/detail.html.twig",
        [
            'author' => $author
        ]);
    }

    #[Route('/delete/{id}', name: 'author_delete')]
    public function deleteAuthor ($id) {
        $author = $this->getDoctrine()->getRepository(Author::class)->find($id);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($author);
        $manager->flush();
        return $this->redirectToRoute("author_index");
    } 
}
