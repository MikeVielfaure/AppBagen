<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Repository\CompteRepository;
use App\Repository\UtilisateurRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use function dd;

/**
 * Description of AccueilUtilisateurController
 *
 * @author vielf
 */
class AccueilUtilisateurController extends AbstractController {
    //put your code here
    
    /**
     *
     * @var Utilisateur
     */
    private $utilisateur;
    
     function __construct() {
       
    }

    
    /**
     * @Route ("/accueil/utilisateur", name="accueil.utilisateur", methods={"GET"})
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function index(Request $request, UserInterface $user, CompteRepository $compteRepository ):Response {
        
        try {
        
        //$this->denyAccessUnlessGranted('ROLE_USER');
        //$lesComptes = $user->getComptes();
        $lesComptes = $compteRepository->findByIdutilisateur($user->getId());
        $tousComptes = $compteRepository->findByIdutilisateurTous($user->getId());
        $liste=[];
        foreach($tousComptes as $compte){
           array_push($liste, $compte->getIntitule()); 
        }
        //dd($lesComptes[1]->getPourcentageBudgetDepense());
        return $this->render("pages/accueilutilisateur.html.twig",[
            'lesComptes' => $lesComptes, 'liste'=> $liste, 'numero' => 1
        ]);
        
        } catch (Exception $e) {
            return $this->redirectToRoute('identification');
        }
    }
    
    /**
     * @Route ("/accueil/utilisateur/search", name="accueil.utilisateur.search", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function search(Request $request, UserInterface $user, CompteRepository $compteRepository ):Response {
        $intitule = $request->get("intitule");
        //dd($intitule);
        //$this->denyAccessUnlessGranted('ROLE_USER');
        //$lesComptes = $user->getComptes();
        $leCompte = $compteRepository->findByIntituleIdutilisateur($intitule, $user->getId());
       
        $tousComptes = $compteRepository->findByIdutilisateurTous($user->getId());
        $liste=[];
        foreach($tousComptes as $compte){
           array_push($liste, $compte->getIntitule()); 
        }
        //dd($lesComptes[1]->getPourcentageBudgetDepense());
        return $this->render("pages/accueilutilisateur.html.twig",[
            'lesComptes' => $leCompte, 'liste'=> $liste, 'numero' => 1
        ]);
    }
    
    /**
     * @Route ("/accueil/utilisateur/plus/{numero}", name="accueil.utilisateur.plus", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function plus($numero, UserInterface $user, CompteRepository $compteRepository ):Response {
        $lesComptes = $compteRepository->findByIdutilisateur($user->getId());
        $tousComptes = $compteRepository->findByIdutilisateurTous($user->getId());
        $liste=[];
        foreach($tousComptes as $compte){
           array_push($liste, $compte->getIntitule()); 
        }
        if($numero >= count($tousComptes)-2)
        {
            $nouveaunumero = $numero;
        }else{
            $nouveaunumero = $numero + 1;
        }
        
        //dd($lesComptes[1]->getPourcentageBudgetDepense());
        return $this->render("pages/accueilutilisateur.html.twig",[
            'lesComptes' => $tousComptes, 'liste'=> $liste, 'numero' => $nouveaunumero
        ]);
    }
    
    /**
     * @Route ("/accueil/utilisateur/moins/{numero}", name="accueil.utilisateur.moins", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function moins($numero, UserInterface $user, CompteRepository $compteRepository ):Response {
        $lesComptes = $compteRepository->findByIdutilisateur($user->getId());
        $tousComptes = $compteRepository->findByIdutilisateurTous($user->getId());
        $liste=[];
        foreach($tousComptes as $compte){
           array_push($liste, $compte->getIntitule()); 
        }
        if($numero <= 1 )
        {
            $nouveaunumero = $numero;
        }else{
            $nouveaunumero = $numero - 1;
        }
        //dd($lesComptes[1]->getPourcentageBudgetDepense());
        return $this->render("pages/accueilutilisateur.html.twig",[
            'lesComptes' => $tousComptes, 'liste'=> $liste, 'numero' => $nouveaunumero
        ]);
    }
}
