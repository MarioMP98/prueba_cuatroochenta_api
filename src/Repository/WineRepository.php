<?php

namespace App\Repository;

use App\Entity\Wine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Wine>
 */
class WineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wine::class);
    }

    public function list(): array
    {
        $entityManager = $this->getEntityManager();
        $sql = 'SELECT w FROM App\Entity\Wine w';

        $query = $entityManager->createQuery($sql);

        return $query->getResult();
    }


    public function create($params): Wine
    {
        $wine = new Wine();

        if(isset($params['name'])) {
            $wine->setName($params['name']);
        }

        if(isset($params['year'])) {
            $wine->setYear($params['year']);
        }

        $entityManager = $this->getEntityManager();
        $entityManager->persist($wine);
        $entityManager->flush();

        return $wine;
    }


    public function update($id, $params): Wine|null
    {
        $entityManager = $this->getEntityManager();
        $wine = $this->find($id);

        if($wine) {

            if(isset($params['name'])) {
                $wine->setName($params['name']);
            }

            if(isset($params['year'])) {
                $wine->setYear($params['year']);
            }
            
            $entityManager->flush();
        }

        return $wine;
    }


    public function delete($id): Wine|null
    {
        $entityManager = $this->getEntityManager();
        $wine = $this->find($id);

        if($wine) {
            $entityManager->remove($wine);
            $entityManager->flush();
        }

        return $wine;
    }
}
