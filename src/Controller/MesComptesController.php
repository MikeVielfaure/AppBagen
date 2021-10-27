<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Repository\CompteRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Description of MesComptesController
 *
 * @author vielf
 */
class MesComptesController extends AbstractController  {

   
    function __construct() {
      
       
    }

    
    /**
     * @Route ("/mescomptes", name="mescomptes", methods={"GET"})
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function index(Request $request, UserInterface $user, CompteRepository $compteRepository ):Response {
        
      
       
        //$this->session->set('nbrcompte', 6);
        //$nbrcomptepage = $this->session->get('nbrcompte');
        //$this->denyAccessUnlessGranted('ROLE_USER');
        //$lesComptes = $user->getComptes();
        $lesComptes = $compteRepository->findByIdutilisateurTous($user->getId());
        $liste=[];
        foreach($lesComptes as $compte){
           array_push($liste, $compte->getIntitule()); 
        }
        //dd($lesComptes[1]->getPourcentageBudgetDepense());
        return $this->render("pages/mescomptes.html.twig",[
            'lesComptes' => $lesComptes, 'numeropage' => '1', 'liste' => $liste 
        ]);
    }
    
    /**
     * @Route ("/mescomptes/page+/{numeropage}", name="mescomptes.page.plus", methods={"GET"})
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function pagePlus($numeropage,CompteRepository $compteRepository, UserInterface $user ):Response {
        
        //$this->denyAccessUnlessGranted('ROLE_USER');
        //$lesComptes = $user->getComptes();
        $lesComptes = $compteRepository->findByIdutilisateurTous($user->getId());
        $index =count($lesComptes);
        //dd(round($index/6));
        //round($index/6)//pour arroudir
        if($numeropage < $index/6 ){
        $numeropage = $numeropage+1;
        }
        //dd($lesComptes[1]->getPourcentageBudgetDepense());
        return $this->render("pages/mescomptes.html.twig",[
            'lesComptes' => $lesComptes, 'numeropage' => $numeropage
        ]);
    }
    
    /**
     * @Route ("/mescomptes/page-/{numeropage}", name="mescomptes.page.moins", methods={"GET"})
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function pageMoins($numeropage,CompteRepository $compteRepository, UserInterface $user ):Response {
        
        //$this->denyAccessUnlessGranted('ROLE_USER');
        //$lesComptes = $user->getComptes();
        $lesComptes = $compteRepository->findByIdutilisateurTous($user->getId());
        if($numeropage > 1){
        $numeropage = $numeropage-1;
        }
        
        //dd($lesComptes[1]->getPourcentageBudgetDepense());
        return $this->render("pages/mescomptes.html.twig",[
            'lesComptes' => $lesComptes, 'numeropage' => $numeropage
        ]);
    }
    
    /**
     * @Route ("/mescomptes/page/{numeropage}", name="mescomptes.page", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function page(Request $request, $numeropage,CompteRepository $compteRepository, UserInterface $user ):Response {
        $lesComptes = $compteRepository->findByIdutilisateurTous($user->getId());
        $liste=[];
        foreach($lesComptes as $compte){
           array_push($liste, $compte->getIntitule()); 
        }
        if($request->get('numero') == null){
        //$this->denyAccessUnlessGranted('ROLE_USER');
        //$lesComptes = $user->getComptes();
        //dd($lesComptes[1]->getPourcentageBudgetDepense());
        return $this->render("pages/mescomptes.html.twig",[
            'lesComptes' => $lesComptes, 'numeropage' => $numeropage, 'liste' => $liste
        ]);
        }else{
            if($request->get('numero')>count($lesComptes)){
                $numero = count($lesComptes);
            }else{
                $numero = $request->get('numero');
            }

        //dd($lesComptes[1]->getPourcentageBudgetDepense());
        return $this->render("pages/mescomptes.html.twig",[
            'lesComptes' => $lesComptes, 'numeropage' => $numero, 'liste' => $liste
        ]);
        }
    }
    
    
    
    /**
     * @Route ("/mescomptes/search", name="mescomptes.search", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function search(Request $request,CompteRepository $compteRepository, UserInterface $user ):Response {
        $lesComptes = $compteRepository->findByIdutilisateurTous($user->getId());
        $liste=[];
        foreach($lesComptes as $compte){
           array_push($liste, $compte->getIntitule()); 
        }
        $intitule = $request->get("intitule");
        $leCompte = $compteRepository->findByIntituleIdutilisateur($intitule, $user->getId());
        //dd($lesComptes[1]->getPourcentageBudgetDepense());
        return $this->render("pages/mescomptes.html.twig",[
            'lesComptes' => $leCompte, 'numeropage' => '1', 'liste' => $liste
        ]);
        
        }
    
        
        /**
     * @Route ("/mescomptes/change", name="mescomptes.change", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     * 
     */
    public function change(Request $request, UserInterface $user ){
        
      
        $request->getSession()->set('nbrcompte', $request->get('nbr'));
        
        //return $this->render("pages/mescomptes.html.twig",[
          //  'lesComptes' => $leCompte, 'numeropage' => '1', 'liste' => $liste
       // ]);
        return $this->redirectToRoute('mescomptes');
        }
}
