<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Flea;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
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

    public function save(Flea $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return array
     */
    public function findPopulatedDogIds(): array
    {
        return $this->createQueryBuilder('f')
            ->innerJoin('f.dog', 'd')
            ->select('d.id')
            ->where('f.dog IS NOT NULL')
            ->groupBy('d.id')
            ->getQuery()
            ->getSingleColumnResult();
    }

    /**
     * @return int
     * @throws NoResultException
     * @throws NonUniqueResultException
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
            ->getSingleResult();

        return $query['id'];
    }
}