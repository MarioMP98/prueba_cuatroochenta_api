<?php

namespace App\Service;

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
        $users = $this->repository->findAll();

        return $this->parseUsers($users);
    }


    public function create($params): array
    {

        return $this->parseUser($this->repository->create($params));
    }

}
