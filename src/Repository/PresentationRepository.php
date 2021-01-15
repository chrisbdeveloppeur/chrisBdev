<?php

namespace App\Repository;

use App\Entity\Presentation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Presentation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Presentation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Presentation[]    findAll()
 * @method Presentation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PresentationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Presentation::class);
    }

    // /**
    //  * @return Presentation[] Returns an array of Presentation objects
    //  */

    public function findByPosition($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.position = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }

    public function orderByPosition()
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.position', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }


    /*
    public function findOneBySomeField($value): ?Presentation
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
