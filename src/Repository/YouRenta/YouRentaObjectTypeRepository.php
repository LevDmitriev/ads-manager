<?php

namespace App\Repository\YouRenta;

use App\Entity\YouRenta\YouRentaObjectType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method YouRentaObjectType|null find($id, $lockMode = null, $lockVersion = null)
 * @method YouRentaObjectType|null findOneBy(array $criteria, array $orderBy = null)
 * @method YouRentaObjectType[]    findAll()
 * @method YouRentaObjectType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class YouRentaObjectTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, YouRentaObjectType::class);
    }

    // /**
    //  * @return YouRentaObjectType[] Returns an array of YouRentaObjectType objects
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
    public function findOneBySomeField($value): ?YouRentaObjectType
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
