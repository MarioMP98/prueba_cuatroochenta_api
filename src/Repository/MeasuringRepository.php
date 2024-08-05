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


    public function create($params): Measuring
    {
        $measuring = new Measuring();

        if(isset($params['year'])) {
            $measuring->setYear($params['year']);
        }

        if(isset($params['color'])) {
            $measuring->setColor($params['color']);
        }

        if(isset($params['temperature'])) {
            $measuring->setTemperature($params['temperature']);
        }

        if(isset($params['graduation'])) {
            $measuring->setGraduation($params['graduation']);
        }

        if(isset($params['ph'])) {
            $measuring->setPh($params['ph']);
        }

        $entityManager = $this->getEntityManager();
        $entityManager->persist($measuring);
        $entityManager->flush();

        return $measuring;
    }


    public function update($id, $params): Measuring|null
    {
        $entityManager = $this->getEntityManager();
        $measuring = $this->find($id);

        if($measuring) {

            if(isset($params['year'])) {
                $measuring->setYear($params['year']);
            }
    
            if(isset($params['color'])) {
                $measuring->setColor($params['color']);
            }
    
            if(isset($params['temperature'])) {
                $measuring->setTemperature($params['temperature']);
            }
    
            if(isset($params['graduation'])) {
                $measuring->setGraduation($params['graduation']);
            }
    
            if(isset($params['ph'])) {
                $measuring->setPh($params['ph']);
            }
            
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
}
