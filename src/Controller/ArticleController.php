<?php

namespace App\Controller;

use App\Service\ArticleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ArticleController extends AbstractController{


    public function __construct(
        private readonly ArticleService $articleService
    )
    {}



    #[Route('/article', name: 'app_article_displayAll')]
    public function displayAll(): Response
    {
        $articles = $this->articleService->getAllArticles();
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
            'articles' => $articles
        ]);
    }
}
