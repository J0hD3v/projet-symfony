<?php

namespace App\Service;

use App\Repository\ArticleRepository;

final class ArticleService{


    public function __construct(
        private readonly ArticleRepository $articleRepository
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
}
