<?php

namespace App\Controller;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    protected $service;


    public function __construct(UserService $service)
    {
        $this->service = $service;
    }


    public function register(Request $request, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        
        $this->service->create($request->request->all(), $passwordHasher);

        return new JsonResponse("Se ha creado el usuario correctamente", 200);
    }

}
