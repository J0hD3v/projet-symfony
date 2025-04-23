<?php

namespace App\Service;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;

final class ArticleService{


    public function __construct(
        private readonly ArticleRepository $articleRepository,
        private readonly EntityManagerInterface $em
    )
    {}



    public function getAllArticles(): array
    {
        try {
            $articles = [];
            // Recuperation des articles
            $articles = $this->articleRepository->findAll();

            // dd($articles[0]);

            // Test si la liste est vide
            if (!$articles) {
                throw new \Exception("La liste des articles est vide");
            }


        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $articles;
    }

    public function saveArticle(Article $article) {
        try {
            // Test si l'article n'existe pas déjà
            if ($this->articleRepository->findOneBy([
                'title' => $article->getTitle(),
                "content" => $article->getContent()
            ])) {
                throw new \Exception("Larticle existe déjà");
            }
            $this->em->persist($article);
            $this->em->flush();
            return true;
            // Ajouter en BDD
            // ...

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
