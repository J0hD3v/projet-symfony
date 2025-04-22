<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    public function home(): Response {
        return new Response ("Bienvenue");
    }

    #[Route('/home', name: 'app_home_homedisplay')]
    public function homeDisplay(): Response {
        return $this->render('home/home.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
}