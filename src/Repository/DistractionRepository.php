<?php

namespace App\Repository;

use App\Entity\Distraction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Distraction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Distraction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Distraction[]    findAll()
 * @method Distraction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DistractionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Distraction::class);
    }

    // /**
    //  * @return Distraction[] Returns an array of Distraction objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Distraction
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
