<?php

namespace App\Repository;

use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Utilisateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Utilisateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Utilisateur[]    findAll()
 * @method Utilisateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UtilisateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Utilisateur::class);
    }

    // /**
    //  * @return Utilisateur[] Returns an array of Utilisateur objects
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

    
    public function findOneByEmail($mail): ?Utilisateur
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.mail = :val')
            ->setParameter('val', $mail)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
    
    public function findByMailMotDePasse($mail, $mdp)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.mail = :mail and m.motdepasse = :mdp')
             
            ->setParameter('mail', $mail)
            ->setParameter('mdp', $mdp)
            ->getQuery()
            ->getOneOrNullResult();
    }
    
    public function updateNom($nom, $id){
        return $this->createQueryBuilder('p')
            ->update()
            ->set('p.nom', ':nom')
            ->andWhere('p.id = :id')
            ->setParameter('id', $id)
            ->setParameter('nom', $nom)
            ->getQuery()
            ->getSingleScalarResult();
    }
    
    public function updatePrenom($prenom, $id){
        return $this->createQueryBuilder('p')
            ->update()
            ->set('p.prenom', ':prenom')
            ->andWhere('p.id = :id')
            ->setParameter('id', $id)
            ->setParameter('prenom', $prenom)
            ->getQuery()
            ->getSingleScalarResult();
    }
    
    public function updateAdresse($adresse, $id){
        return $this->createQueryBuilder('p')
            ->update()
            ->set('p.adresse', ':adresse')
            ->andWhere('p.id = :id')
            ->setParameter('id', $id)
            ->setParameter('adresse', $adresse)
            ->getQuery()
            ->getSingleScalarResult();
    }
    
    public function updateCodepostal($codepostal, $id){
        return $this->createQueryBuilder('p')
            ->update()
            ->set('p.codepostal', ':codepostal')
            ->andWhere('p.id = :id')
            ->setParameter('id', $id)
            ->setParameter('codepostal', $codepostal)
            ->getQuery()
            ->getSingleScalarResult();
    }
    
    public function updateVille($ville, $id){
        return $this->createQueryBuilder('p')
            ->update()
            ->set('p.ville', ':ville')
            ->andWhere('p.id = :id')
            ->setParameter('id', $id)
            ->setParameter('ville', $ville)
            ->getQuery()
            ->getSingleScalarResult();
    }
    
    public function updateMotdepasse($mdp, $mail){
        return $this->createQueryBuilder('p')
            ->update()
            ->set('p.motdepasse', ':mdp')
            ->andWhere('p.mail = :mail')
            ->setParameter('mdp', $mdp)
            ->setParameter('mail', $mail)
            ->getQuery()
            ->getSingleScalarResult();
    }
    
    public function updateAll($nom, $prenom, $adresse, $codepostal, $ville, $id){
        return $this->createQueryBuilder('p')
            ->update()
            ->set('p.ville', ':ville')
            ->set('p.codepostal', ':codepostal')
            ->set('p.adresse', ':adresse')
            ->set('p.prenom', ':prenom')
            ->set('p.nom', ':nom')
            ->andWhere('p.id = :id')
            ->setParameter('id', $id)
            ->setParameter('ville', $ville)
            ->setParameter('codepostal', $codepostal)
            ->setParameter('adresse', $adresse)
            ->setParameter('prenom', $prenom)
            ->setParameter('nom', $nom)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
