<?php

namespace App\Service;

use App\Entity\Measuring;
use App\Repository\MeasuringRepository;
use App\Traits\Parser;

class MeasuringService
{
    use Parser;

    protected $repository;


    public function __construct(MeasuringRepository $repository)
    {
        $this->repository = $repository;
    }


    public function list(): array
    {
        $measurings = $this->repository->list();

        return $this->parseMeasurings($measurings);
    }


    public function create($params): Measuring
    {

        return $this->repository->create($params);
    }


    public function update($id, $params): Measuring|null
    {

        return $this->repository->update($id, $params);
    }


    public function delete($id): Measuring|null
    {

        return $this->repository->delete($id);
    }

}
