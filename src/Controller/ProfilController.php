<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Repository\UtilisateurRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use function dd;

/**
 * Description of ProfilController
 *
 * @author vielf
 */
class ProfilController extends AbstractController {
    
    function __construct() {
       
    }

    
    /**
     * @Route ("/profil", name="profil", methods={"GET"})
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function index():Response {
        //$this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render("pages/profil.html.twig");
    }
    
    /**
     * @Route ("/profil/modifier/{champ}", name="profil.modifier", methods={"GET"})
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function modifier($champ):Response {
        //$this->denyAccessUnlessGranted('ROLE_USER');
         
        return $this->render("pages/profil.html.twig");
    }
    
    /**
     * @Route ("/profil/valider/{champ}", name="profil.valider", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function valider($champ, Request $request, UtilisateurRepository $utilisateurRepository, UserInterface $user):Response {
        $lechamp = $request->get($champ);
        switch ($champ) {
    case "nom":
        $utilisateurRepository->updateNom($lechamp, $user->getId());
        break;
    case "prenom":
        $utilisateurRepository->updatePrenom($lechamp, $user->getId());
        break;
    case "adresse":
        $utilisateurRepository->updateAdresse($lechamp, $user->getId());
        break;
    case "codepostal":
        $utilisateurRepository->updateCodepostal($lechamp, $user->getId());
        break;
    case "ville":
        $utilisateurRepository->updateVille($lechamp, $user->getId());
        break;
}
         
        return $this->redirectToRoute('profil');
    }
    
    /**
     * @Route ("/profil/modifier", name="profil.modifier.tous", methods={"GET"})
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function modifierTous():Response {
        //$this->denyAccessUnlessGranted('ROLE_USER');
         
        return $this->render("pages/profilmodifier.html.twig");
    }
    
    /**
     * @Route ("/profil/valider", name="profil.valider.tous", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function validerTous( Request $request, UtilisateurRepository $utilisateurRepository, UserInterface $user):Response {
        $nom = $request->get("nom");
        $prenom = $request->get("prenom");
        $adresse = $request->get("adresse");
        $codepostal = $request->get("codepostal");
        $ville = $request->get("ville");
        
        $utilisateurRepository->updateAll($nom, $prenom, $adresse, $codepostal, $ville, $user->getId());
        
         
        return $this->redirectToRoute('profil');
    }
}
