<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use function PHPUnit\Framework\throwException;

#[Route('/book')]
class BookController extends AbstractController
{
    #[Route('', name: 'book_index')]
    public function bookIndex (BookRepository $bookRepository) {
        //B1: lấy dữ liệu từ database
        //SELECT * FROM book
        //$book = $this->getDoctrine()->getRepository(Book::class)->findAll();
        //SELECT * FROM book ORDER BY id DESC
        $book = $bookRepository->viewBookList();
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
        if ($book == null) {
            $this->addFlash("Error","Book not found !");
            return $this->redirectToRoute("book_index");
        }
        return $this->render("book/detail.html.twig",
            [
                'book' => $book
            ]);
    }

     /** 
     * @IsGranted("ROLE_STAFF")
     */  
    #[Route('/delete/{id}', name: 'book_delete')]
    public function bookDelete ($id) {
        //DELETE FROM book WHERE id = '$id'
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);
        //check xem book có tồn tại trong db hay không
        if ($book == null) {
            //gửi flash message từ controller đến view
            $this->addFlash("Error","Book not found !");
        } else {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($book);
            $manager->flush();
            $this->addFlash("Success","Delete book succeed !");
        }
        return $this->redirectToRoute("book_index");
    }

    /** 
     * @IsGranted("ROLE_ADMIN")
     */    
    #[Route('/add', name: 'book_add')]
    public function bookAdd(Request $request) {
        //tạo 1 object Book mới
        $book = new Book;
        //tạo object cho form 
        $form = $this->createForm(BookType::class,$book);
        //form handle request
        $form->handleRequest($request);
        //check form submit và form validation
        if ($form->isSubmitted() && $form->isValid()) {
            //code để xử lý việc upload ảnh & set tên mới cho ảnh    
            //B1: lấy tên ảnh từ file upload
            $image = $book->getImage();
            //B2: đặt tên mới cho file ảnh
            //=> đảm bảo tên file ảnh là duy nhất trong db
            $imgName = uniqid(); //unique id
            //B3: lấy phần đuôi của tên file ảnh (image extension)
            $imgExtension = $image->guessExtension();
            //Note: cần update lại code phần getter & setter trong Entity
            //B4: nối tên và đuôi thành tên mới cho ảnh  
            $imageName = $imgName . '.' . $imgExtension;
            //B5: di chuyển ảnh vào thư mục chỉ định trong project
            try {
                $image->move(
                    $this->getParameter('book_cover'), $imageName
                );  
            } catch (FileException $e) {
                throwException($e);
            }
            //B6: lưu tên ảnh vào DB
            $book->setImage($imageName); 
            //tạo object cho EntityManager
            $manager = $this->getDoctrine()->getManager();
            //add dữ liệu object book vào db
            $manager->persist($book);
            //confirm thao tác add dữ liệu
            $manager->flush();
            //redirect về trang book index
            return $this->redirectToRoute("book_index");
        }
        return $this->renderForm("book/add.html.twig",
        [
            'BookForm' => $form
        ]);
    }

    /** 
     * @IsGranted("ROLE_STAFF")
     */ 
    #[Route('/edit/{id}', name: 'book_edit')]
    public function bookEdit(Request $request, $id) {
        //lấy object Book theo id từ db
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);
         //tạo object cho form 
         $form = $this->createForm(BookType::class,$book);
         //form handle request
         $form->handleRequest($request);
         //check form submit và form validation
         if ($form->isSubmitted() && $form->isValid()) {
            //code để xử lý việc upload ảnh & set tên mới cho ảnh 
            //B1: lấy dữ liệu ảnh từ form
            $file = $form['image']->getData();
            //B2: check xem dữ liệu ảnh có null không
            if ($file != null) {
                //người dùng bấm Browse file để có thể update ảnh mới
                //B1: lấy tên ảnh từ file upload
                $image = $book->getImage();
                //B2: đặt tên mới cho file ảnh
                //=> đảm bảo tên file ảnh là duy nhất trong db
                $imgName = uniqid(); //unique id
                //B3: lấy phần đuôi của tên file ảnh (image extension)
                $imgExtension = $image->guessExtension();
                //Note: cần update lại code phần getter & setter trong Entity
                //B4: nối tên và đuôi thành tên mới cho ảnh  
                $imageName = $imgName . '.' . $imgExtension;
                //B5: di chuyển ảnh vào thư mục chỉ định trong project
                try {
                    $image->move(
                        $this->getParameter('book_cover'), $imageName
                    );  
                } catch (FileException $e) {
                    throwException($e);
                }
                //B6: lưu tên ảnh vào DB
                $book->setImage($imageName); 
            }  
             //tạo object cho EntityManager
             $manager = $this->getDoctrine()->getManager();
             //add dữ liệu object book vào db
             $manager->persist($book);
             //confirm thao tác edit dữ liệu
             $manager->flush();
             //redirect về trang book index
             return $this->redirectToRoute("book_index");
         }
         return $this->renderForm("book/edit.html.twig",
         [
             'BookForm' => $form
         ]);
    }

    #[Route('/search', name: 'book_search')]
    public function bookSearch (Request $request,  BookRepository $bookRepository) {
        $title = $request->get("title");
        $book = $bookRepository->searchBook($title);
        return $this->render("book/index.html.twig",
            [
                'books' => $book
            ]);
    }
}

