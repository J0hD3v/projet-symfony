<?php

namespace App\Service;

use App\Repository\CategoryRepository;

final class CategoryService{


    public function __construct(
        private readonly CategoryRepository $categoryRepository
    )
    {}



    public function getAllCategories(): array
    {
        try {

            // Recuperation des categories
            $categories = $this->categoryRepository->findAll();

            // Test si la liste est vide
            if (!$categories) {
                throw new \Exception("La liste des catégories est vide");
            }


        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $categories;
    }
}
