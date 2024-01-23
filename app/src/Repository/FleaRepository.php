<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Flea;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Flea|null find($id, $lockMode = null, $lockVersion = null)
 * @method Flea|null findOneBy(array $criteria, array $orderBy = null)
 * @method Flea[]    findAll()
 * @method Flea[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FleaRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Flea::class);
    }

    /**
     * @return array
     */
    public function findHomed(): array
    {
        return $this->createQueryBuilder('f')
            ->where('f.dog IS NOT NULL')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return int
     */
    public function findOneDogIdWithLowPopulation(): int
    {
        $query = $this->createQueryBuilder('f')
            ->innerJoin('f.dog', 'd')
            ->select(['d.id', 'count(f.dog) AS total'])
            ->groupBy('f.dog')
            ->orderBy('total', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();

        return $query[0]['id'];
    }
}