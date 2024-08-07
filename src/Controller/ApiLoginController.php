<?php

namespace App\Controller;

use App\Entity\User;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class ApiLoginController extends AbstractController
{
    /**
     * Grants access to an existing user.
     *
     * If it gets through the email and password validation, it grants access to the user
     */
    #[OA\Response(
        response: 200,
        description: 'The logged in user',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: User::class))
        )
    )]
    #[OA\Parameter(
        name: 'email',
        in: 'query',
        description: 'The email assigned as the user\' key',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'password',
        in: 'query',
        description: 'The password corresponding to that user',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Tag(name: 'login')]
    public function login(#[CurrentUser] ?User $user): Response
    {

        if (null === $user) {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $this->json([
            'user'  => $user->getUserIdentifier(),
        ]);
    }

    /**
     * Logs out the user currently in use.
     *
     * Logs out the user and revokes their access to the protected routes
     */
    #[OA\Response(
        response: 200,
        description: 'The logged in user',
        content: new OA\JsonContent(
            type: 'redirection'
        )
    )]
    #[OA\Tag(name: 'logout')]
    public function logout(Security $security): Response
    {

        return $security->logout(false);
    }
}
