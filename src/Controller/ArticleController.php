<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Service\ArticleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ArticleController extends AbstractController{


    public function __construct(
        private readonly ArticleService $articleService
    )
    {}



    #[Route('/article', name: 'app_article_displayAll')]
    public function displayAll(): Response
    {
        $articles = $this->articleService->getAllArticles();
        return $this->render('article/displayAll.html.twig', [
            'controller_name' => 'ArticleController',
            'articles' => $articles
        ]);
    }

    #[Route('/article/add', name: 'app_article_add')]
    #[IsGranted("ROLE_USER")]
    public function add(Request $request): Response
    {
        // Objet article (recevoir le résultat du formulaire)
        $article = new Article();
        // Créer une objet Form
        $form = $this->createForm(ArticleType::class, $article);
        // Récupération du résultat de la requête
        $form->handleRequest($request);

        // Si le formulaire est soumis
        if ($form->isSubmitted()) {
            // dd($form);
            try {
                $msg = '';
                $type = '';
                if ($this->articleService->saveArticle($article)) {
                    $msg = "L'article " . $article->getTitle() . " a été ajouté";
                    $type = "success";
                }
            } catch (\Exception $e) {
                $msg = ($e->getMessage());
                $type = "danger";
            }
            $this->addFlash($type, $msg);
        }

        return $this->render('article/add.html.twig', [
            'formulaire' => $form
        ]);
    }
}
