<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

final class UserService{


    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly EntityManagerInterface $em
    )
    {}



    public function addUser(User $user): bool {
        try {
            // Test si l'utilisateur n'existe pas déjà
            if ($this->userRepository->findOneBy([
                "email" => $user->getEmail()
            ])) {
                throw new \Exception("L'utilisateur existe déjà");
            }
            $this->em->persist($user);
            $this->em->flush();
            return true;
            // Ajouter en BDD
            // ...

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
