<?php

namespace App\Repository;

use App\Entity\Sensor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sensor>
 */
class SensorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sensor::class);
    }

    public function list(): array
    {
        $entityManager = $this->getEntityManager();
        $sql = 'SELECT s FROM App\Entity\Sensor s ORDER BY s.name';

        $query = $entityManager->createQuery($sql);

        return $query->getResult();
    }


    public function create($params): Sensor
    {
        $sensor = new Sensor();

        if(isset($params['name'])) {
            $sensor->setName($params['name']);
        }

        $entityManager = $this->getEntityManager();
        $entityManager->persist($sensor);
        $entityManager->flush();

        return $sensor;
    }


    public function update($id, $params): Sensor|null
    {
        $entityManager = $this->getEntityManager();
        $sensor = $this->find($id);

        if($sensor) {

            if(isset($params['name'])) {
                $sensor->setName($params['name']);
            }
            
            $entityManager->flush();
        }

        return $sensor;
    }


    public function delete($id): Sensor|null
    {
        $entityManager = $this->getEntityManager();
        $sensor = $this->find($id);

        if($sensor) {
            $entityManager->remove($sensor);
            $entityManager->flush();
        }

        return $sensor;
    }
}
