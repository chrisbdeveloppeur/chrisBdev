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

    public function findAllByNote()
    {
        return $this->createQueryBuilder('a')
//            ->andWhere('a.note = :val')
//            ->setParameter('val', $value)
            ->orderBy('a.note', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllByDate()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.date', 'DESC')
            ->setMaxResults(50)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByValidate()
    {
        return $this->createQueryBuilder('a')
            ->Where('a.validated = :val')
            ->setParameter('val', true)
            ->orderBy('a.date', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
            ;
    }


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
