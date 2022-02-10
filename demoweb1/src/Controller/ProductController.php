<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/product')]
class ProductController extends AbstractController
{
  #[Route('', name: 'product_index')]
  public function productList()
  {
      //lấy dữ liệu từ DB
      $product = $this->getDoctrine()->getRepository(Product::class)->findAll();
      //render ra view (template)
      return $this->render("product/index.html.twig",
          [
            'product' => $product
          ]
      );
  }
  
  #[Route('/detail/{id}', name: 'product_detail')]
  public function productDetail($id) {
      $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
      return $this->render("product/detail.html.twig",
          [
              'product' => $product
          ]
    );
  }

  #[Route('/delete/{id}', name: 'product_delete')]
  public function productDelete($id) {
    $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
    $manager = $this->getDoctrine()->getManager();
    $manager->remove($product);
    $manager->flush();
    return $this->redirectToRoute("product_index");
  }

  #[Route('/add', name: 'product_add')]
  public function productAdd (Request $request){
    $product = new Product;
    $form = $this->createForm(ProductType::class, $product);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($product);
        $manager->flush();
        return $this->redirectToRoute("product_index");
    }

    return $this->renderForm("product/add.html.twig",
    [
        'productForm' => $form
    ]);
  }

  #[Route('/edit/{id}', name: 'product_edit')]
  public function productEdit (Request $request, $id) {
    $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
    $form = $this->createForm(ProductType::class, $product);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($product);
        $manager->flush();
        return $this->redirectToRoute("product_index");
    }

    return $this->renderForm("product/edit.html.twig",
    [
        'productForm' => $form
    ]);
  }
}
