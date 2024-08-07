<?php

namespace App\Controller;

use App\Service\UserService;
use App\Traits\Parser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends AbstractController
{
    use Parser;

    protected $service;
    protected $security;


    public function __construct(UserService $service, Security $security)
    {
        $this->service = $service;
        $this->security = $security;
    }

    public function list(): JsonResponse
    {
        
        $users = $this->service->list();

        return new JsonResponse($users, 200);
    }


    public function register(Request $request): JsonResponse
    {
        
        $user = $this->service->create($request->request->all());

        return new JsonResponse($user, 201);
    }

}
