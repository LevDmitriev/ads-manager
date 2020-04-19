<?php

namespace App\Repository\YouRenta;

use App\Entity\YouRenta\YouRentaCityDistrict;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method YouRentaCityDistrict|null find($id, $lockMode = null, $lockVersion = null)
 * @method YouRentaCityDistrict|null findOneBy(array $criteria, array $orderBy = null)
 * @method YouRentaCityDistrict[]    findAll()
 * @method YouRentaCityDistrict[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class YouRentaCityDistrictRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, YouRentaCityDistrict::class);
    }

    // /**
    //  * @return YouRentaCityDistrict[] Returns an array of YouRentaCityDistrict objects
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
    public function findOneBySomeField($value): ?YouRentaCityDistrict
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
