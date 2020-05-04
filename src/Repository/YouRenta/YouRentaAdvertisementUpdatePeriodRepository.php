<?php

namespace App\Repository\YouRenta;

use App\Entity\YouRenta\YouRentaAdvertisementUpdatePeriod;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method YouRentaAdvertisementUpdatePeriod|null find($id, $lockMode = null, $lockVersion = null)
 * @method YouRentaAdvertisementUpdatePeriod|null findOneBy(array $criteria, array $orderBy = null)
 * @method YouRentaAdvertisementUpdatePeriod[]    findAll()
 * @method YouRentaAdvertisementUpdatePeriod[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class YouRentaAdvertisementUpdatePeriodRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, YouRentaAdvertisementUpdatePeriod::class);
    }

    // /**
    //  * @return YouRentaAdvertisementUpdatePeriod[] Returns an array of YouRentaAdvertisementUpdatePeriod objects
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
    public function findOneBySomeField($value): ?YouRentaAdvertisementUpdatePeriod
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
