<?php

namespace App\Controller;

use App\Entity\ToDo;
use App\Form\ToDoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ToDoController extends AbstractController
{
    //nhập dữ liệu vào form nhưng không add vào DB
    #[Route('/new', name: 'todo_new')]
    public function newTodo(Request $request) {
        //tạo object mới bằng Todo entity (model)
        $todo = new ToDo;
        //tạo dữ liệu trong form
        $form = $this->createFormBuilder($todo)
                     ->add('Title', TextType::class)
                     ->add('Content', TextType::class)
                     ->add('Date', DateType::class,
                            [
                                'widget' => 'single_text'
                            ])
                     ->add('Create', SubmitType::class)
                     ->getForm();
        //xử lý form
        $form->handleRequest($request);
        //sau khi form đã submit và đã được xác thực
        //lấy dữ liệu từ form và gửi sang trang success
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $title = $data->getTitle();
            $content = $data->getContent();
            $date = $data->getDate();
            return $this->render("todo/success.html.twig",
                                [
                                    'title' => $title,
                                    'content' => $content,
                                    'date' => $date
                                ]);
        }
        //render ra file view chứa form để nhập liệu
        return $this->render("todo/new.html.twig",
                            [
                                'todoForm' => $form->createView()
                            ]);
    }

    //nhập dữ liệu vào form nhưng add vào DB
    #[Route('/add', name: 'todo_add')]
    public function addTodo (Request $request) {
        $todo = new ToDo;
        $form = $this->createForm(ToDoType::class, $todo);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($todo);
            $manager->flush();
            return $this->redirectToRoute("todo_list");
        }
        return $this->renderForm('todo/new.html.twig',
                                [
                                    'todoForm' => $form
                                ]);
    }

    #[Route('/list', name: 'todo_list')]
    public function viewTodo () {
        $todos = $this->getDoctrine()->getRepository(ToDo::class)->findAll();
        return $this->render("todo/list.html.twig",
                                [
                                    'todos' => $todos
                                ]);
    }
}
