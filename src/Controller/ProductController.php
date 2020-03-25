<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ProductType;
use App\Entity\Product;
use Doctrine\ORM\EntityManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductController extends AbstractController
{

    /**
     * @Route("/product", name="product_index")
     */
    public function index()
    {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findAll();

        return $this->render('product/index.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/product/edit/{id}", name="product_edit")
     */
    public function edit(Request $request, Product $product)
    {

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('product_index');
        }


        return $this->render('product/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/product/delete/{id}", name="product_delete")
     */
    public function delete(Product $product)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($product);
        $entityManager->flush();

        return $this->redirectToRoute('product_index');

    }


    /**
     * @Route("/product/create", name="product_create")
     */
    public function create(Request $request, SluggerInterface $slugger)
    {
        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $product->setSlug($slugger->slug($product->getName())->lower());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);

            $entityManager->flush();
        }


        return $this->render('product/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/product/{$slug}", name="product_show")
     */
    public function show($slug)
    {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findOneBy(['slug' => $slug]);

        if (!$product) {
            throw $this->createNotFoundException();
        }

        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }
}
