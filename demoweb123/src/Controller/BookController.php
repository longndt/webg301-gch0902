<?php

namespace App\Controller;

use App\Entity\Book;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/book')]
class BookController extends AbstractController
{
    #[Route('', name: 'book_index')]
    public function bookIndex () {
        //B1: lấy dữ liệu từ database
        //SELECT * FROM book
        $book = $this->getDoctrine()->getRepository(Book::class)->findAll();
        //B2: render ra view và gửi kèm dữ liệu
        return $this->render("book/index.html.twig",
            [
                'books' => $book
            ]);
    }

    #[Route('/detail/{id}', name: 'book_detail')]
    public function bookDetail ($id) {
        //SELECT * FROM book WHERE id = '$id'
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);
        return $this->render("book/detail.html.twig",
            [
                'book' => $book
            ]);
    }

    #[Route('/delete/{id}', name: 'book_delete')]
    public function bookDelete ($id) {
        //DELETE FROM book WHERE id = '$id'
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($book);
        $manager->flush();
        return $this->redirectToRoute("book_index");
    }
}
