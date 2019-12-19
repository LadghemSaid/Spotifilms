<?php

namespace App\Repository;

use App\Entity\Comments;
use App\Entity\Series;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Comments|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comments|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comments[]    findAll()
 * @method Comments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comments::class);
    }
    public function findAllCommentsBySerie(Series $series, $order){
        if($order == 'ASC') {
            return $this->createQueryBuilder('c')
                ->setParameter('series', $series)
                ->where('c.Series = :series')
                ->orderBy('c.positive', 'DESC')
                ->getQuery()
                ->getResult();
        } else if($order == 'DESC') {
            return $this->createQueryBuilder('c')
                ->setParameter('series', $series)
                ->where('c.Series = :series')
                ->orderBy('c.positive','ASC')
                ->getQuery()
                ->getResult();
        } else {
            return $this->createQueryBuilder('c')
                ->setParameter('series', $series)
                ->where('c.Series = :series')
                ->getQuery()
                ->getResult();
        }
    }

    public function averageValidatedCommentsBySerie(Series $series) {
        return $this->createQueryBuilder('c')
            ->select('AVG(c.validated)')
            ->setParameter('series', $series)
            ->where('c.Series = :series')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findAllByUser($user){
        return $this->createQueryBuilder('c')
            ->setParameter('series', $user)
            ->where('c.Series = :series')
            ->getQuery()
            ->getResult();
    }


    // /**
    //  * @return Comments[] Returns an array of Comments objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Comments
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
