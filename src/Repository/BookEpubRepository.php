<?php

namespace App\Repository;

use App\Entity\BookEpub;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BookEpub|null find($id, $lockMode = null, $lockVersion = null)
 * @method BookEpub|null findOneBy(array $criteria, array $orderBy = null)
 * @method BookEpub[]    findAll()
 * @method BookEpub[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookEpubRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookEpub::class);
    }

    // /**
    //  * @return BookEpub[] Returns an array of BookEpub objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BookEpub
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
