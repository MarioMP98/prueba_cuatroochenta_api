<?php

namespace App\Service;

use App\Entity\Wine;
use App\Repository\WineRepository;
use App\Traits\Parser;

class WineService
{
    use Parser;

    protected $repository;


    public function __construct(WineRepository $repository)
    {
        $this->repository = $repository;
    }


    public function list(): array
    {
        $wines = $this->repository->list();

        return $this->parseWines($wines);
    }


    public function create($params): Wine
    {

        return $this->repository->create($params);
    }


    public function update($id, $params): Wine|null
    {

        return $this->repository->update($id, $params);
    }


    public function delete($id): Wine|null
    {

        return $this->repository->delete($id);
    }

}
