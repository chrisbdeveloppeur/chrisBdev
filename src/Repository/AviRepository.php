<?php

namespace App\Repository;

use App\Entity\Avi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Avi|null find($id, $lockMode = null, $lockVersion = null)
 * @method Avi|null findOneBy(array $criteria, array $orderBy = null)
 * @method Avi[]    findAll()
 * @method Avi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AviRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Avi::class);
    }

    // /**
    //  * @return Avi[] Returns an array of Avi objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Avi
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
