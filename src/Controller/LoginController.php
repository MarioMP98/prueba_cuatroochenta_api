<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class LoginController extends AbstractController
{

    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function index(#[CurrentUser] ?User $user): JsonResponse
    {

        if (null === $user) {
            return $this->json([
                 'message' => 'missing credentials',
             ], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $token = '';

        return $this->json([
            'user'  => $user->getUserIdentifier(),
            'token' => $token,
        ]);
    }
}