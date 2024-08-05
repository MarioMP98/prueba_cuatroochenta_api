<?php

namespace App\Service;

use App\Entity\Sensor;
use App\Repository\SensorRepository;
use App\Traits\Parser;

class SensorService
{
    use Parser;

    protected $repository;


    public function __construct(SensorRepository $repository)
    {
        $this->repository = $repository;
    }


    public function list(): array
    {
        $sensors = $this->repository->list();

        return $this->parseSensors($sensors);
    }


    public function create($params): Sensor
    {

        return $this->repository->create($params);
    }


    public function update($id, $params): Sensor|null
    {

        return $this->repository->update($id, $params);
    }


    public function delete($id): Sensor|null
    {

        return $this->repository->delete($id);
    }

}
