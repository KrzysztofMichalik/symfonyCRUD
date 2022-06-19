<?php
namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends AbstractController
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    #[Route('/', name: 'app_main')]
    public function index() : Response
    {
        $data = $this->productRepository->findAllWithCategory();

        return $this->render('main/index.html.twig', [
            'data' => $data,
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request) : Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->productRepository->add($product, true);
            $this->addFlash('notice', 'Product added to database');
            return $this->redirectToRoute('app_main');
        }

        return $this->render('main/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/get/{id<\d+>}', name: 'get')]
    public function get(int $id) : Response
    {
        $data = $this->productRepository->findOneWithCategory($id);
        if (!$data) {
            throw $this->createNotFoundException();
        }
        return $this->render('main/getSingle.html.twig', [
            'data' => $data,
        ]);
    }

    #[Route('/update/{id<\d+>}', name: 'update')]
    public function update(Request $request, int $id) : Response
    {
        $data = $this->productRepository->findOneWithCategory($id);
        if (!$data) {
            throw $this->createNotFoundException();
        }
        $form = $this->createForm(ProductType::class, $data);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $this->productRepository->update($data, true);
            $this->addFlash('notice', 'Update Successfully');
            return $this->redirectToRoute('app_main');
        }

        return $this->render('main/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete/{id<\d+>}', name: 'delete')]
    public function delete(int $id) : Response
    {
        $data = $this->productRepository->find($id);
        $this->productRepository->remove($data, true);
        $this->addFlash('notice', 'Deleted Successfully');

        return $this->redirectToRoute('app_main');
    }
}
