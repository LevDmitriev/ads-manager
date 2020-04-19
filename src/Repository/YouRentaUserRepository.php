<?php

namespace App\Repository;

use App\Entity\YouRentaUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method YouRentaUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method YouRentaUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method YouRentaUser[]    findAll()
 * @method YouRentaUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class YouRentaUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, YouRentaUser::class);
    }

    // /**
    //  * @return YouRentaUser[] Returns an array of YouRentaUser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('y')
            ->andWhere('y.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('y.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?YouRentaUser
    {
        return $this->createQueryBuilder('y')
            ->andWhere('y.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
