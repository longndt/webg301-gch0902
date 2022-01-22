<?php

namespace App\Controller;

use App\Entity\Blog;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class BlogController extends AbstractController
{
   //class variable - global variable
   public $serializerInterface;

   //constructor
   public function __construct(SerializerInterface $serializerInterface) {
       $this->serializerInterface = $serializerInterface;
   }

   //READ - SELECT * FROM Blog 
   #[Route('/', methods : 'GET', name: 'index')]
   public function blogIndex() {
      //lấy dữ liệu từ bảng Blog trong DB và lưu vào array
      $blogs = $this->getDoctrine()->getRepository(Blog::class)->findAll();  
      //convert từ array thành json
      $json = $this->serializerInterface->serialize($blogs,'json');
      //convert từ array thành xml
      $xml = $this->serializerInterface->serialize($blogs,'xml');
      //trả về response cho client
      return new Response($json,
                          Response::HTTP_OK,  //status: 200
                          [
                              'content-type' => 'application/json'
                          ]
      );
   }

   //READ - SELECT * FROM Blog WHERE id = '$id'
   #[Route('/{id}', methods: 'GET', name: 'detail')]
   public function blogDetail($id) {
        //lấy dữ liệu từ bảng Blog trong DB và lưu vào object
        $blog = $this->getDoctrine()->getRepository(Blog::class)->find($id);  
        //kiểm tra blog object có null không
        if ($blog == null) {
            $error = json_encode("Blog not found");
            return new Response($error,
                                Response::HTTP_NOT_FOUND  //status: 404)
            );
        }
        //convert từ object thành json
        $json = $this->serializerInterface->serialize($blog,'json');
        //convert từ object thành xml
        $xml = $this->serializerInterface->serialize($blog,'xml');
        //trả về response cho client
        return new Response($json,
                        Response::HTTP_OK,  //status: 200
                        [
                            'content-type' => 'application/json'
                        ]
        );
   }

   //DELETE - DELETE FROM Blog WHERE id = '$id'
   #[Route('/{id}', methods: 'DELETE', name: 'delete')]
   public function blogDelete($id) {
      //lấy dữ liệu từ bảng Blog trong DB và lưu vào object
      $blog = $this->getDoctrine()->getRepository(Blog::class)->find($id);  
      //kiểm tra blog object có null không
      if ($blog == null) {
          $error = json_encode("Blog not found");
          return new Response($error,
                              Response::HTTP_NOT_FOUND  //status: 404
          );
      }
      //xóa dữ liệu từ DB bằng entity manager
      $manager = $this->getDoctrine()->getManager();
      $manager->remove($blog);
      $manager->flush();
      return new Response(null, Response::HTTP_NO_CONTENT //status: 204
      );
   }

   //CREATE - INSERT INTO Blog (...) VALUES (...)
   #[Route('/', methods : 'POST', name: 'add')]
   public function blogAdd(Request $request) {
      $blog = new Blog;
      $data = json_decode($request->getContent(),true);
      $blog->setTitle($data['title']);
      $blog->setAuthor($data['author']);
      $blog->setContent($data['content']);
      $blog->setDate(\DateTime::createFromFormat('Y-m-d',$data['date']));  

      $manager = $this->getDoctrine()->getManager();
      $manager->persist($blog);
      $manager->flush();

      return new Response(null, Response::HTTP_CREATED //status: 201
      );
   }

   //UPDATE - UPDATE Blog SET ... = ...
   #[Route('/{id}', methods: 'PUT', name: 'edit')]
   public function blogEdit($id, Request $request) {
        $blog = $this->getDoctrine()->getRepository(Blog::class)->find($id);
        if ($blog == null) {
            $error = json_encode("Blog not found");
            return new Response($error,
                                Response::HTTP_NOT_FOUND  //status: 404
            );
        }
        $data = json_decode($request->getContent(),true);
        $blog->setTitle($data['title']);
        $blog->setAuthor($data['author']);
        $blog->setContent($data['content']);
        $blog->setDate(\DateTime::createFromFormat('Y-m-d',$data['date']));  

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($blog);
        $manager->flush();

        return new Response(null, Response::HTTP_NO_CONTENT //status: 204
        );
   }
}
