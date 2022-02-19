<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use Symfony\Component\HttpFoundation\Request;
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
        } 
        //check xem author có publish author hay không
        else if (count($author->getAuthors()) != 0) {
            $this->addFlash("Error","Can not delete this author !");
        }
        else {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($author);
            $manager->flush();
            $this->addFlash("Success","Delete author succeed !");
        }
        return $this->redirectToRoute("author_index");
    }

    #[Route('/add', name: 'author_add')]
    public function authorAdd(Request $request) {
        //tạo 1 object Author mới
        $author = new Author;
        //tạo object cho form 
        $form = $this->createForm(AuthorType::class,$author);
        //form handle request
        $form->handleRequest($request);
        //check form submit và form validation
        if ($form->isSubmitted() && $form->isValid()) {
            //tạo object cho EntityManager
            $manager = $this->getDoctrine()->getManager();
            //add dữ liệu object author vào db
            $manager->persist($author);
            //confirm thao tác add dữ liệu
            $manager->flush();
            //redirect về trang author index
            return $this->redirectToRoute("author_index");
        }
        return $this->renderForm("author/add.html.twig",
        [
            'AuthorForm' => $form
        ]);
    }

    #[Route('/edit/{id}', name: 'author_edit')]
    public function authorEdit(Request $request, $id) {
        //lấy object Author theo id từ db
        $author = $this->getDoctrine()->getRepository(Author::class)->find($id);
         //tạo object cho form 
         $form = $this->createForm(AuthorType::class,$author);
         //form handle request
         $form->handleRequest($request);
         //check form submit và form validation
         if ($form->isSubmitted() && $form->isValid()) {
             //tạo object cho EntityManager
             $manager = $this->getDoctrine()->getManager();
             //add dữ liệu object author vào db
             $manager->persist($author);
             //confirm thao tác edit dữ liệu
             $manager->flush();
             //redirect về trang author index
             return $this->redirectToRoute("author_index");
         }
         return $this->renderForm("author/edit.html.twig",
         [
             'AuthorForm' => $form
         ]);
    }
}

