<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\UserService;
use App\Traits\Parser;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends AbstractController
{
    use Parser;

    protected $service;
    protected $security;


    public function __construct(UserService $service)
    {
        $this->service = $service;
    }


    /**
     * Lists the existing users.
     *
     * Retrieves and shows a list of all the users in the database.
     */
    #[OA\Response(
        response: 200,
        description: 'The list of users',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: User::class))
        )
    )]
    #[OA\Tag(name: 'user_list')]
    public function list(): JsonResponse
    {
        
        $users = $this->service->list();

        return new JsonResponse($users, 200);
    }


    /**
     * Registers a new user.
     *
     * Creates a new user in the database with the data passed through the request.
     */
    #[OA\Response(
        response: 201,
        description: 'The recently created user',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: User::class))
        )
    )]
    #[OA\Parameter(
        name: 'email',
        in: 'query',
        description: 'The email that will be used to login. It must be unique.',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'password',
        in: 'query',
        description: 'The password that will be required to login.',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'name',
        in: 'query',
        description: 'The user\'s name',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'last_name',
        in: 'query',
        description: 'The user\'s last name or last names',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Tag(name: 'user_register')]
    public function register(Request $request): JsonResponse
    {
        
        $user = $this->service->create($request->request->all());

        return new JsonResponse($user, 201);
    }

}
