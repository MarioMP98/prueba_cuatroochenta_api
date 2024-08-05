<?php

namespace App\Service;

use App\Entity\Measuring;
use App\Repository\MeasuringRepository;
use App\Repository\SensorRepository;
use App\Repository\WineRepository;
use App\Traits\Parser;

class MeasuringService
{
    use Parser;

    protected $repository;
    protected $sensorRepository;
    protected $wineRepository;


    public function __construct(
        MeasuringRepository $repository,
        SensorRepository $sensorRepository,
        WineRepository $wineRepository
    ) {
        $this->repository = $repository;
        $this->sensorRepository = $sensorRepository;
        $this->wineRepository = $wineRepository;
    }


    public function list(): array
    {
        $measurings = $this->repository->list();

        return $this->parseMeasurings($measurings);
    }


    public function create($params): Measuring
    {
        [$sensor, $wine] = $this->getSensorAndWine($params);

        return $this->repository->create($params, $sensor, $wine);
    }


    public function update($id, $params): Measuring|null
    {
        [$sensor, $wine] = $this->getSensorAndWine($params);

        return $this->repository->update($id, $params, $sensor, $wine);
    }


    public function delete($id): Measuring|null
    {

        return $this->repository->delete($id);
    }

    private function getSensorAndWine($params): array
    {
        $sensor = null;
        $wine = null;

        if (isset($params['sensor'])) {
            $sensor = $this->sensorRepository->find($params['sensor']);
        }

        if (isset($params['wine'])) {
            $wine = $this->wineRepository->find($params['wine']);
        }

        return [$sensor, $wine];
    }

}
