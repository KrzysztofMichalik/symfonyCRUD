<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class ProductController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(ManagerRegistry $doctrine)
    {
        $data = $doctrine->getRepository(Product::class)->findAll();

        return $this->render('main/index.html.twig', [
         'productList' => $data,
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request,ManagerRegistry $doctrine)
    {

        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $doctrine->getManager();
            $em->persist($product);
            $em->flush();
            $this->addFlash('notice', 'Product added to database');

            return $this->redirectToRoute('app_main');
        }

        return $this->render('main/create.html.twig', [
            'form' => $form->createView(),
        ]);

    }
    #[Route('/get/{id}', name: 'get')]
    public function get($id, ManagerRegistry $doctrine)
    {
        $product = $doctrine->getRepository(Product::class)->find($id);
        $category = $product->getCategory()->getName();
        return $this->render('main/getSingle.html.twig', [
            'data' => $product,
            'category' => $category,
        ]);

    }
    #[Route('/update/{id}', name: 'update')]
    public function update(Request $request, $id, ManagerRegistry $doctrine)
    {

        $product = $doctrine->getRepository(Product::class)->find($id);
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $doctrine->getManager();
            $em->persist($product);
            $em->flush();
            $this->addFlash('notice', 'Update Successfully');

            return $this->redirectToRoute('app_main');
        }

        return $this->render('main/update.html.twig', [
            'form' => $form->createView(),
        ]);

    }
    #[Route('/delete/{id}', name: 'delete')]
    public function delete($id, ManagerRegistry $doctrine)
    {
        $product = $doctrine->getRepository(Product::class)->find($id);
        $em = $doctrine->getManager();
        $em->remove($product);
        $em->flush();
        $this->addFlash('notice', 'Deleted Successfully');

        return $this->redirectToRoute('app_main');
    }
}
