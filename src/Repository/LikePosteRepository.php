<?php

namespace App\Repository;

use App\Entity\LikePoste;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LikePoste|null find($id, $lockMode = null, $lockVersion = null)
 * @method LikePoste|null findOneBy(array $criteria, array $orderBy = null)
 * @method LikePoste[]    findAll()
 * @method LikePoste[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LikePosteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LikePoste::class);
    }

    // /**
    //  * @return LikePoste[] Returns an array of LikePoste objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LikePoste
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
