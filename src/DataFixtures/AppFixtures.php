<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture; 
use Doctrine\Persistence\ObjectManager; 
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //création d'une variable qui va contenir 
        $faker = Faker\Factory::create('fr_FR'); 
        //Tableau vide qui va stocker les utilisateurs que je génère 
        $users = [];
        //Boucle qui va itérer 50 utilisateurs factices 
        for($i=0; $i<50; $i++){ 
            $user = new User();
            $user->setLastName($faker->lastName());
            $user->setFirstName($faker->firstname());
            $user->setEmail($faker->email());
            $user->setPassword($faker->password());
            $user->setRoles(["ROLE_USER"]);
            //stockage dans le manager
            $manager->persist($user);
            $users[] = $user;
        }
        $categories = [];
        //Boucle qui va itérer 100 catégories factices 
        for($i=0; $i<100; $i++){
            $categorie = new Category();
            $categorie->setLabel($faker->unique()->word());
            //stockage dans le manager
            $manager->persist($categorie);
            $categories[] = $categorie;
        }
        $articles = [];
        //Boucle qui va itérer 200 articles factices 
        for($i=0; $i<200; $i++){
            $article = new Article();
            $article->setTitle($faker->jobTitle());
            $article->setContent($faker->catchPhrase());
            $article->setCreatedAt(new \DateTimeImmutable($faker->date('Y-m-d')));
            do {
                $randomIndex1 = rand(0,count($categories)-1);
                $randomIndex2 = rand(0,count($categories)-1);
                $randomIndex3 = rand(0,count($categories)-1);
            } while ($randomIndex1 == $randomIndex2 || $randomIndex1 == $randomIndex3 || $randomIndex2 == $randomIndex3);
            $article->addCategory($categories[$randomIndex1]);
            $article->addCategory($categories[$randomIndex2]);
            $article->addCategory($categories[$randomIndex3]);
            $randomIndex4 = rand(0,count($users)-1);
            $article->setUser($users[$randomIndex4]);
            //stockage dans le manager
            $manager->persist($article);
            $articles[] = $article;
        }
        $manager->flush();
    }
}
