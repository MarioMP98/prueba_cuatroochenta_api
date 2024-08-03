<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    protected $service;


    public function __construct(UserRepository $service)
    {
        $this->service = $service;
    }


    #[Route('api/register', name: 'app_registration')]
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        
        $this->service->create($request->request->all(), $passwordHasher);

        return new JsonResponse("Se ha creado el usuario correctamente", 200);
    }

}
