<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Entity\Budget;
use App\Entity\Depense;
use App\Entity\Utilisateur;
use App\Repository\BudgetRepository;
use App\Repository\CompteRepository;
use App\Repository\DepenseRepository;
use App\Repository\UtilisateurRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use function dd;

/**
 * Description of CompteController
 *
 * @author vielf
 */
class CompteController extends AbstractController{
    
      /**
     *
     * @var Utilisateur
     */
    private $utilisateur;
    
     function __construct() {
       
    }

    
    /**
     * @Route ("/compte/{id}", name="compte", methods={"GET"})
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function index($id, CompteRepository $compteRepository):Response {
        $leCompte = $compteRepository->findOneById($id);
        //dd($leCompte);
        //$this->denyAccessUnlessGranted('ROLE_USER');
        //$lesComptes = $user->getComptes();
        //$lesComptes = $compteRepository->findByIdutilisateur($user->getId());
        //dd($lesComptes[1]->getPourcentageBudgetDepense());
        return $this->render("pages/affichercompte.html.twig",["compte" => $leCompte
                ]
        );
    }
    
    /**
     * @Route ("/cloture/{id}", name="cloture", methods={"GET"})
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function cloture($id, CompteRepository $compteRepository):Response {
        $leCompte = $compteRepository->findOneById($id);
        //dd($leCompte);
        //$this->denyAccessUnlessGranted('ROLE_USER');
        //$lesComptes = $user->getComptes();
        //$lesComptes = $compteRepository->findByIdutilisateur($user->getId());
        //dd($lesComptes[1]->getPourcentageBudgetDepense());
        return $this->render("pages/affichercomptecloture.html.twig",["compte" => $leCompte
                ]
        );
    }
    
    /**
     * @Route ("/compte/modifie/budget/{id}", name="compte.modifie.budget", methods={"GET"})
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function modifieBudget($id, CompteRepository $compteRepository):Response {
        $leCompte = $compteRepository->findOneById($id);
        //dd($leCompte);
        //$this->denyAccessUnlessGranted('ROLE_USER');
        //$lesComptes = $user->getComptes();
        //$lesComptes = $compteRepository->findByIdutilisateur($user->getId());
        //dd($lesComptes[1]->getPourcentageBudgetDepense());
        return $this->render("pages/comptemodifiebudget.html.twig",["compte" => $leCompte
                ]
        );
    }
    
    /**
     * @Route ("/compte/valider/budget/{id}", name="compte.valider.budget", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function validerBudget($id, CompteRepository $compteRepository, Request $request, UserInterface $user, BudgetRepository $budgetRepository, EntityManagerInterface $om):Response {
        $leCompte = $compteRepository->findOneById($id);
        $nouveauBudget = $request->get("montant");
        //dd($request->get("montant"));
        $date=date("Y-m-d");
        if($budgetRepository->findOneByIdcompte($id) == null){
            $lebudget = new Budget;
            $lebudget->setDate($date);
            $lebudget->setIdcompte($leCompte);
            $lebudget->setMontant($nouveauBudget);
            $om->persist($lebudget);
            $om->flush();
        }
        $budgetRepository->updateMontant($nouveauBudget, $id);
        $compteRepository->updateDateModif($id,$date);
        //dd($leCompte);
        //$this->denyAccessUnlessGranted('ROLE_USER');
        //$lesComptes = $user->getComptes();
        //$lesComptes = $compteRepository->findByIdutilisateur($user->getId());
        //dd($lesComptes[1]->getPourcentageBudgetDepense());
        return $this->redirectToRoute('compte',array('id' => $id));
    }
    
    /**
     * @Route ("/compte/modifie/depense/{id}", name="compte.modifie.depense", methods={"GET"})
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function modifieDepense($id, CompteRepository $compteRepository, DepenseRepository $depenseRepository):Response {
        $laDepense = $depenseRepository->findOneById($id);
        $leCompte = $compteRepository->findOneById($laDepense->getIdcompte());
        //dd($laDepense->getId());
        //$this->denyAccessUnlessGranted('ROLE_USER');
        //$lesComptes = $user->getComptes();
        //$lesComptes = $compteRepository->findByIdutilisateur($user->getId());
        //dd($lesComptes[1]->getPourcentageBudgetDepense());
        return $this->render("pages/comptemodifiedepense.html.twig",["compte" => $leCompte, "id" => $laDepense->getId()
                ]
        );
    }
    
    /**
     * @Route ("/compte/valider/depense/{id}", name="compte.valider.depense", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function validerDepense($id, CompteRepository $compteRepository, DepenseRepository $depenseRepository, Request $request):Response {
        $laDepense = $depenseRepository->findOneById($id);
        $leCompte = $compteRepository->findOneById($laDepense->getIdcompte());
        $libelle = $request->get("libelle");
        $montant = $request->get("montant");
        $ladate = $request->get("ladate");
        //$ladate = $this->dateFrancaisVersAnglais($ladate);
        $depenseRepository->updateDepense($id, $ladate, $libelle, $montant);
        $date=date("Y-m-d");
        
        $compteRepository->updateDateModif($leCompte->getId(),$date);
        //dd($ladate);
        //$this->denyAccessUnlessGranted('ROLE_USER');
        //$lesComptes = $user->getComptes();
        //$lesComptes = $compteRepository->findByIdutilisateur($user->getId());
        //dd($lesComptes[1]->getPourcentageBudgetDepense());
        return $this->redirectToRoute('compte',array('id' => $leCompte->getId()));
    }
    
     /**
     * @Route ("/compte/ajouter/depense/{id}", name="compte.ajouter.depense", methods={"GET"})
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function ajouterDepense($id, CompteRepository $compteRepository):Response {
        $leCompte = $compteRepository->findOneById($id);
        //dd($leCompte);
        //$this->denyAccessUnlessGranted('ROLE_USER');
        //$lesComptes = $user->getComptes();
        //$lesComptes = $compteRepository->findByIdutilisateur($user->getId());
        //dd($lesComptes[1]->getPourcentageBudgetDepense());
        return $this->render("pages/ajouterdepense.html.twig",["compte" => $leCompte
                ]
        );
    }
    
    /**
     * @Route ("/compte/depense/{id}", name="compte.depense", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function depense($id, CompteRepository $compteRepository, Request $request, EntityManagerInterface $om):Response {
        $leCompte = $compteRepository->findOneById($id);
        $libelle = $request->get("libelle");
        $montant = $request->get("montant");
        $ladate = $request->get("ladate");
        
        //$ladate = $this->dateFrancaisVersAnglais($ladate);
        //$date = new Date($ladate);
        
        $depense = new Depense;
        $depense->setLibelle($libelle);
        $depense->setMontant($montant);
        $depense->setDate(DateTime::createFromFormat('Y-m-d', $ladate));
        $depense->setIdcompte($leCompte);
        $om->persist($depense);
        $om->flush();
        //dd($leCompte);
        //$this->denyAccessUnlessGranted('ROLE_USER');
        //$lesComptes = $user->getComptes();
        //$lesComptes = $compteRepository->findByIdutilisateur($user->getId());
        //dd($lesComptes[1]->getPourcentageBudgetDepense());
        return $this->redirectToRoute('compte',array('id' => $id));
    }

    /**
     * @Route ("/compte/supprimer/depense/{id}", name="compte.supprimer.depense", methods={"GET"})
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function supprimerDepense($id, CompteRepository $compteRepository, DepenseRepository $depenseRepository, EntityManagerInterface $om):Response {
        $laDepense = $depenseRepository->findOneById($id);
        $idCompte = $laDepense->getIdcompte()->getId();
        //dd($idCompte);
        $leCompte = $compteRepository->findOneById($idCompte);
        //dd($request->get("montant"));
        $date=date("Y-m-d");
        //$depenseRepository->updateMontant($nouveauBudget, $id);
        $compteRepository->updateDateModif($idCompte,$date);
        $om->remove($laDepense);
        $om->flush();
        //dd($leCompte);
        //$this->denyAccessUnlessGranted('ROLE_USER');
        //$lesComptes = $user->getComptes();
        //$lesComptes = $compteRepository->findByIdutilisateur($user->getId());
        //dd($lesComptes[1]->getPourcentageBudgetDepense());
        return $this->redirectToRoute('compte',array('id' => $idCompte));
    }
    
    /**
     * @Route ("/compte/supprimer/{id}", name="compte.supprimer", methods={"GET"})
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function supprimerCompte($id, CompteRepository $compteRepository, DepenseRepository $depenseRepository, BudgetRepository $budgetrepository ,EntityManagerInterface $om):Response {
       
        $leCompte = $compteRepository->findOneById($id);
        
        $lebudget = $budgetrepository->findByIdcompte($id);
        $lesdepenses = $depenseRepository->findByIdcompte($id);
     
        foreach ($lebudget as $budget){
            $om->remove($budget);
            $om->flush();
        }
        
        foreach ($lesdepenses as $depense){
            $om->remove($depense);
            $om->flush();
        }

        $om->remove($leCompte);
        $om->flush();
        //dd($leCompte);
        //$this->denyAccessUnlessGranted('ROLE_USER');
        //$lesComptes = $user->getComptes();
        //$lesComptes = $compteRepository->findByIdutilisateur($user->getId());
        //dd($lesComptes[1]->getPourcentageBudgetDepense());
        return $this->redirectToRoute('accueil.utilisateur');
    }
    
    /**
     * @Route ("/compte/supprimer/confirmer/{id}", name="compte.supprimer.confirmer", methods={"GET"})
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function supprimerCompteConfirmer($id, CompteRepository $compteRepository):Response {
        $leCompte = $compteRepository->findOneById($id);
        //dd($leCompte);
        //$this->denyAccessUnlessGranted('ROLE_USER');
        //$lesComptes = $user->getComptes();
        //$lesComptes = $compteRepository->findByIdutilisateur($user->getId());
        //dd($lesComptes[1]->getPourcentageBudgetDepense());
        return $this->render("pages/affichercompte.html.twig",["compte" => $leCompte
                ]
        );
    }
    
     /**
     * @Route ("/compte/cloturer/confirmer/{id}", name="compte.cloturer.confirmer", methods={"GET"})
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function cloturerCompteConfirmer($id, CompteRepository $compteRepository):Response {
        $leCompte = $compteRepository->findOneById($id);
        //dd($leCompte);
        //$this->denyAccessUnlessGranted('ROLE_USER');
        //$lesComptes = $user->getComptes();
        //$lesComptes = $compteRepository->findByIdutilisateur($user->getId());
        //dd($lesComptes[1]->getPourcentageBudgetDepense());
        return $this->render("pages/affichercompte.html.twig",["compte" => $leCompte
                ]
        );
    }
    
    /**
     * @Route ("/compte/cloturer/{id}", name="compte.cloturer", methods={"GET"})
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function cloturerCompte($id, CompteRepository $compteRepository):Response {
        $date=date("Y-m-d");
        $compteRepository->updateDateCloture($id, $date);
        
        
        
        return $this->redirectToRoute('cloture',array('id' => $id));
    }
    
    function dateFrancaisVersAnglais($maDate)
    {
        @list($jour, $mois, $annee) = explode('-', $maDate);
        return $annee."-".$mois."-".$jour;
    }
    
    
}
