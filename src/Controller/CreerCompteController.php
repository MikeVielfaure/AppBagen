<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Entity\Budget;
use App\Entity\Compte;
use App\Form\CompteRegistrationFormType;
use App\Form\UserRegistrationFormType;
use App\Repository\CompteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

use DateTime;
use DateTimeInterface;
use function dd;

/**
 * Description of CreerCompteController
 *
 * @author vielf
 */
class CreerCompteController extends AbstractController {
    //put your code here
    
     function __construct() {
       
    }

    
    /**
     * @Route ("/creer/compte/nouveau", name="creer.compte.nouveau", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function index(EntityManagerInterface $om, Request $request, UserInterface $user, CompteRepository $compteRepository):Response {
        $form = $this->createForm(CompteRegistrationFormType::class);
        //dd($form);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $compte = $form->getData();
            $date=date("Y-m-d");
            $compte->setDatecreation(DateTime::createFromFormat('Y-m-d', $date));
            $compte->setDatemodif(DateTime::createFromFormat('Y-m-d', $date));
            $compte->setIdutilisateur($user);
            $compte->setIntitule($compte->getIntitule());
            $om->persist($compte);
            $om->flush();
            if($form['monBudget']->getData() != null){
                $lecompte = $compteRepository->findOneByIntitule($compte->getIntitule());
                $budget = new Budget;
                $budget->setMontant($form['monBudget']->getData());
                $budget->setIdcompte($lecompte);
                $budget->setDate($date);
                $om->persist($budget);
                $om->flush();
            }
            //$utilisateur->setMotdepasse($passwordEncoder->encodePassword($utilisateur, $plainMotdepasse));
           
            //$this->addFlash('succes', 'Utilisateur créé avec succès !');
            
            return $this->redirectToRoute('accueil.utilisateur');
        }
        return $this->render("pages/creercompte.html.twig",[
            'registrationForm' => $form->createView()
        ]);
    }
    
    
    
}
