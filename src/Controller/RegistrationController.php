<?php

namespace App\Controller;

use App\Service\UserService;
use App\Traits\Parser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

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


    public function register(Request $request): JsonResponse
    {
        
        $user = $this->service->create($request->request->all());

        return new JsonResponse($user, 201);
    }

    #[Route('/profile', name:'user.profile')]
    public function profile(Request $request): JsonResponse
    {
        $user = $this->security->getUser();

        return new JsonResponse($this->parseUser($user), 200);
    }

}
