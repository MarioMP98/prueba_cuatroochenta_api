<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Traits\Parser;

class UserService
{
    use Parser;

    protected $repository;


    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }


    public function list(): array
    {
        $users = $this->repository->list();

        return $this->parseUsers($users);
    }


    public function create($params, $passwordHasher): User
    {

        return $this->repository->create($params, $passwordHasher);
    }

}
