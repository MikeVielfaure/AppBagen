<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of SecretController
 *
 * @author vielf
 */
class SecretController extends AbstractController {
    //put your code here
    
    
     function __construct() {
       
    }

    
    /**
     * @Route ("/secret", name="secret", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function index():Response {
        //$this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render("pages/secret.html.twig", [
            'titre'=>"titren"
        ]);
    }
    
    /**
     * @Route ("/secret/test", name="secret.test", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function test(Request $request):Response {
        //$this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render("pages/secret.html.twig", [
            'titre'=> $request->get('titre')
        ]);
    }
    
}
