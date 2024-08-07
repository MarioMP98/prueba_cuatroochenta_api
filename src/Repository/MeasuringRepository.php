<?php

namespace App\Repository;

use App\Entity\Measuring;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Measuring>
 */
class MeasuringRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Measuring::class);
    }

    public function list(): array
    {
        $entityManager = $this->getEntityManager();
        $sql = 'SELECT m FROM App\Entity\Measuring m';

        $query = $entityManager->createQuery($sql);

        return $query->getResult();
    }


    public function create($params, $sensor, $wine): Measuring
    {
        $measuring = new Measuring();

        $this->asignParameters($measuring, $params, $sensor, $wine);

        $entityManager = $this->getEntityManager();
        $entityManager->persist($measuring);
        $entityManager->flush();

        return $measuring;
    }


    public function update($id, $params, $sensor, $wine): Measuring|null
    {
        $entityManager = $this->getEntityManager();
        $measuring = $this->find($id);

        if($measuring) {

            $this->asignParameters($measuring, $params, $sensor, $wine);

            $entityManager->flush();
        }

        return $measuring;
    }


    public function delete($id): Measuring|null
    {
        $entityManager = $this->getEntityManager();
        $measuring = $this->find($id);

        if($measuring) {
            $entityManager->remove($measuring);
            $entityManager->flush();
        }

        return $measuring;
    }


    private function asignParameters($measuring, $params, $sensor, $wine): void
    {

        if(isset($params['year'])) {
            $measuring->setYear(intval($params['year']) ?: null);
        }

        if(isset($params['color'])) {
            $measuring->setColor($params['color']);
        }

        if(isset($params['temperature'])) {
            $measuring->setTemperature(doubleval($params['temperature']));
        }

        if(isset($params['graduation'])) {
            $measuring->setGraduation(doubleval($params['graduation']));
        }

        if(isset($params['ph'])) {
            $measuring->setPh(doubleval($params['ph']));
        }

        if($sensor) {
            $measuring->setSensor($sensor);
        }

        if($wine) {
            $measuring->setWine($wine);
        }
    }
}
