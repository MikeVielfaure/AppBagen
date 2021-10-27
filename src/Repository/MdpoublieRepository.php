<?php

namespace App\Repository;

use App\Entity\Mdpoublie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Mdpoublie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mdpoublie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mdpoublie[]    findAll()
 * @method Mdpoublie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MdpoublieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mdpoublie::class);
    }

    // /**
    //  * @return Mdpoublie[] Returns an array of Mdpoublie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Mdpoublie
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
