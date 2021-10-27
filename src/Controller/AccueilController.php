<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of AccueilController
 *
 * @author vielf
 */
class AccueilController extends AbstractController {
    //put your code here
    
  
   
    function __construct() {
       
    }

    
    /**
     * @Route ("/", name="accueil", methods={"GET"})
     * @return Response
     */
    public function index():Response {
        //$utilisateur = $this->utilisateurRepository->findByMailMotDePasse($mail, $mdp);
        return $this->render("pages/accueil.html.twig");
    }
    
    
}
