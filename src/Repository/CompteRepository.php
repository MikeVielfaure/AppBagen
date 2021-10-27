<?php

namespace App\Repository;

use App\Entity\Compte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Compte|null find($id, $lockMode = null, $lockVersion = null)
 * @method Compte|null findOneBy(array $criteria, array $orderBy = null)
 * @method Compte[]    findAll()
 * @method Compte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Compte::class);
    }

    // /**
    //  * @return Compte[] Returns an array of Compte objects
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
    public function findOneBySomeField($value): ?Compte
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    
    /**
     * retourne les 3 derniers comptes modifiés
    * @return Compte[] Returns an array of Compte objects
    */
    
    public function findByIdutilisateur($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.idutilisateur = :val')
            ->setParameter('val', $value)
            ->orderBy('c.datemodif', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult()
        ;
    }
    
    public function updateDateModif($idcompte,$date){
        return $this->createQueryBuilder('p')
            ->update()
            ->set('p.datemodif', ':date')
            ->andWhere('p.id = :idcompte')
            ->setParameter('idcompte', $idcompte)
            ->setParameter('date', $date)
            ->getQuery()
            ->getSingleScalarResult();
    }
    
    public function updateDateCloture($idcompte,$date){
        return $this->createQueryBuilder('p')
            ->update()
            ->set('p.datecloture', ':date')
            ->andWhere('p.id = :idcompte')
            ->setParameter('idcompte', $idcompte)
            ->setParameter('date', $date)
            ->getQuery()
            ->getSingleScalarResult();
    }
    
    public function findByIdutilisateurTous($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.idutilisateur = :val')
            ->setParameter('val', $value)
            ->orderBy('c.datemodif', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
    
    public function findByIntituleIdutilisateur($intitule, $idutilisateur){
        return $this->createQueryBuilder('c')
            ->andWhere('c.idutilisateur = :idutilisateur')
            ->andWhere('c.intitule = :intitule')
            ->setParameter('intitule', $intitule)
            ->setParameter('idutilisateur', $idutilisateur)
            ->getQuery()
            ->getResult()
        ;
    }
    
}
