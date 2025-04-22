<?php

namespace App\Controller;

use App\Service\CategoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CategoryController extends AbstractController{


    public function __construct(
        private readonly CategoryService $categoryService
    )
    {}



    #[Route('/category', name: 'app_category_displayAll')]
    public function displayAll(): Response
    {
        $categories = $this->categoryService->getAllCategories();
        // var_dump($categories);
        // dd($categories);
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
            'categories' => $categories
        ]);
    }
}
