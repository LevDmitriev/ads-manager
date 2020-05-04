<?php

namespace App\Repository\YouRenta;

use App\Entity\YouRenta\YouRentaAdvertisement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method YouRentaAdvertisement|null find($id, $lockMode = null, $lockVersion = null)
 * @method YouRentaAdvertisement|null findOneBy(array $criteria, array $orderBy = null)
 * @method YouRentaAdvertisement[]    findAll()
 * @method YouRentaAdvertisement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class YouRentaAdvertisementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, YouRentaAdvertisement::class);
    }

    // /**
    //  * @return YouRentaAdvertisement[] Returns an array of YouRentaAdvertisement objects
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
    public function findOneBySomeField($value): ?YouRentaAdvertisement
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
