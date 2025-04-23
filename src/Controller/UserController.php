<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController{

    public function __construct(
        private readonly UserService $userService
    )
    {}

    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/user/add', name: 'app_user_add')]
    public function add(Request $request): Response
    {
        // Objet user (recevoir le résultat du formulaire)
        $user = new User();
        // Créer une objet Form
        $form = $this->createForm(UserType::class, $user);
        // Récupération du résultat de la requête
        $form->handleRequest($request);

        // Si le formulaire est soumis
        if ($form->isSubmitted() && $form->isValid()) {
            // dd($form);
            try {
                $msg = '';
                $type = '';
                if ($this->userService->addUser($user)) {
                    $msg = "L'utilisateur " . $user->getFirstname() . " a été ajouté";
                    $type = "success";
                }
            } catch (\Exception $e) {
                $msg = ($e->getMessage());
                $type = "danger";
            }
            $this->addFlash($type, $msg);
        }

        return $this->render('user/add.html.twig', [
            'formulaire' => $form
        ]);
    }
}
