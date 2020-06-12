<?php

namespace App\Repository;

use App\Entity\LikeCommentaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LikeCommentaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method LikeCommentaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method LikeCommentaire[]    findAll()
 * @method LikeCommentaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LikeCommentaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LikeCommentaire::class);
    }

    // /**
    //  * @return LikeCommentaire[] Returns an array of LikeCommentaire objects
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
    public function findOneBySomeField($value): ?LikeCommentaire
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
