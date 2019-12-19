<?php

namespace App\Repository;

use App\Entity\Series;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function findAllUsersWhoSawSerie(Series $series){
        return $this->createQueryBuilder('u')
            ->innerJoin('u.Episodes', 'e')
            ->setParameter('serie', $series)
            ->where('e.Series = : serie')
            ->getQuery()
            ->getResult();
    }


    public function findAllSeenEpisodes(User $user){
        return $this->createQueryBuilder('u')
            ->innerJoin('u.Episodes', 'e')
            ->setParameter('user',$user)
            ->where('u =  :user')
            ->orderBy('e.Series', 'ASC')
            ->addOrderBy('e.number', 'ASC')
            ->getQuery()
            ->getResult();
    }
    public function findAllSeenSeries(User $user){
        return $this->createQueryBuilder('u')
            ->setParameter('user' , $user)
            ->where('u = :user')
            ->innerJoin('u.Episodes','e')
            ->innerJoin('e.Series', 's')
            ->andWhere('e.Series = s')
            ->getQuery()
            ->getResult();

    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
