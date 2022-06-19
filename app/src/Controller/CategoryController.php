<?php
namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    #[Route('/create_category', name: 'category_create')]
    public function create(Request $request) : Response
    {
        $data = new Category();
        $form = $this->createForm(CategoryType::class, $data);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->categoryRepository->add($data);
            $this->addFlash('notice', 'Category added to database');
            return $this->redirectToRoute('app_main');
        }

        return $this->render('category/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
