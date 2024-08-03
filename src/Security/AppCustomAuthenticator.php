<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\CustomCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;

class AppCustomAuthenticator extends AbstractAuthenticator
{
    protected $userRepository;
    protected $passwordHasher;

    public function __construct(UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher)
    {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
    }

    public function supports(Request $request): ?bool
    {

        return $request->getPathInfo() === '/api/login' && $request->isMethod('POST');

    }

    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('email');
        $password = $request->request->get('password');

        $badge = new UserBadge($email, function($userIdentifier) {

            $user = $this->userRepository->findOneBy(['email' => $userIdentifier]);

            if (!$user) {

                throw new UserNotFoundException();
            }

            return $user;
        });

        $customCredentials = new CustomCredentials(function($credentials, User $user) {
            return $this->passwordHasher->isPasswordValid($user, $credentials);
        }, $password);

        return new Passport($badge, $customCredentials);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?JsonResponse
    {
        return new JsonResponse("Session iniciada");
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?JsonResponse
    {
        return new JsonResponse([
            'message' => 'missing credentials',
        ], JsonResponse::HTTP_UNAUTHORIZED);
    }
}
