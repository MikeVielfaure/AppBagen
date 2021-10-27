<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Entity\Mdpoublie;
use App\Form\UserRegistrationFormType;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Exception\LogicException;
use function dd;

/**
 * Description of IdentificationController
 *
 * @author vielf
 */
class IdentificationController extends AbstractController {
    //put your code here
    
    /**
     *
     * @var UtilisateurRepository
     */
    private $utilisateurRepository;
    
    /**
     *
     * @var string
     */
    private $etat;
    
    
    
    
    public const OLD_MAIL = 'old_mail';
   
  
    /**
     * 
     * @param UtilisateurRepository $utilisateurRepository
     */
    function __construct(UtilisateurRepository $utilisateurRepository, EntityManagerInterface $om) {
        $this->utilisateurRepository = $utilisateurRepository;
    }

    
    /**
     * @Route ("/register", name="register", methods={"GET","POST"})
     * @return Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $om, MailerInterface $mailer):Response {
        $form = $this->createForm(UserRegistrationFormType::class);
        //dd($form);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $utilisateur = $form->getData();
            
            $plainMotdepasse = $form['PlainMotdepasse']->getData();
            
            
            $utilisateur->setMotdepasse($passwordEncoder->encodePassword($utilisateur, $plainMotdepasse));
            
            $om->persist($utilisateur);
            $om->flush();
            
            $this->addFlash('succes', 'Utilisateur créé avec succès !');
            
            
            $email = (new TemplatedEmail())
                    ->from('bagen@alwaysdata.net')
                    ->to($form['mail']->getData())
                    ->subject('Enregistrement confirmé')
                    ->htmlTemplate("layouts/partials/_mailcontact.html.twig")
                    ->context([
                        'titre' => 'Bienvenue sur Bagen',
                        'message' => 'Nous vous souhaitons la bienvenue sur Bagen',
                        'mail' => 'bagen@alwaysdata.net'
                    ]);
            $mailer->send($email);
            
            return $this->redirect('identification');
        }
        
        return $this->render("pages/register.html.twig",[
            'registrationForm' => $form->createView()
        ]);
    }
    
    /**
     * @Route ("/identification", name="identification", methods={"GET","POST"})
     * @return Response
     */
    public function index(Request $request):Response {
        $this->etat = "0";
        //$request->getSession()->set('nbrcompte', 6);
       
            
        //$utilisateur = $this->utilisateurRepository->findByMailMotDePasse($mail, $mdp);
       
      
            $request->getSession()->set('nbrcompte', 6);
            return $this->render("pages/identification.html.twig",['etat' => $this->etat  
        ]);
        
    }
    
    /**
     * @Route ("/logout", name="logout", methods={"GET"})
     * @return Response
     */
    public function logout():Response {
        
        
        throw new LogicException('This method can be blank - it will be intercepted by the logout '
                . 'key on your firewall');
       
    }
    
    
    /**
     * @Route ("/erreur", name="identification.erreur")
     * @return Response
     */
    /*
    public function identificationErreur():Response {
        $this->etat = "1";
        //$utilisateur = $this->utilisateurRepository->findByMailMotDePasse($mail, $mdp);
        return $this->render("pages/identification.html.twig",['etat' => $this->etat
        ]);
    }*/
    
    
    /**
     * @Route ("/connexion", name="identification.connexion")
     * @param Request $request
     * @return Response
     */
    /*
    public function ajout(Request $request): Response {
        $mail = $request->get("mail");
        $mdp = $request->get("mdp");
        $utilisateur = $this->utilisateurRepository->findByMailMotDePasse($mail, $mdp);
        if($utilisateur == null){
            return $this->redirectToRoute('identification.erreur', array('champ'=>"1"));
        }else{
            return $this->redirectToRoute('accueil');
        }
        
       
    }*/
    
    
    /**
     * @Route ("/test/{id}", name="test", methods={"GET","POST"})
     * @return Response
     */
    public function test($id):Response {
        dd($id);
        //$utilisateur = $this->utilisateurRepository->findByMailMotDePasse($mail, $mdp);
        return $this->render("pages/identification.html.twig",['etat' => $this->etat
        ]);
    }
    
    /**
     * @Route ("/identification/oublie", name="identification.oublie", methods={"GET","POST"})
     * @return Response
     */
    public function oublie(Request $request,EntityManagerInterface $om ,UtilisateurRepository $utilisateurRepository, MailerInterface $mailer):Response {
        $mail = $request->get('email');
        $utilisateur = $utilisateurRepository->findOneByMail($mail);
        if($utilisateur != null){
            
            //création de l'objet mdpoublie dans la bdd
            $mdpoublie = new Mdpoublie ;
            $mdpoublie->setMail($mail);
            $code = $this->textAleat(8);
            $lien = "http://localhost/bagen/public/index.php/modifie/motdepasse/"
                    . $code;
            $mdpoublie->setCode($code);
            $om->persist($mdpoublie);
            $om->flush();
            
            //creation du mail et lien pour l'utilisateur
            $email = (new TemplatedEmail())
                    ->from('bagen@alwaysdata.net')
                    ->to($mail)
                    ->subject('Demande de modification de Mot de passe')
                    ->htmlTemplate("layouts/partials/_mailcontact.html.twig")
                    ->context([
                        'titre' => 'Modification mot de passe',
                        'message' => 'Pour modifier votre mot de passe vous pouvez cliquer sur ce lien : '
                        . $lien,
                        'mail' => 'bagen@alwaysdata.net'
                    ]);
            $mailer->send($email);
            $this->addFlash('succes', 'un mail vous a été envoyé');
            return $this->redirectToRoute("identification");
        }else{
        //$utilisateur = $this->utilisateurRepository->findByMailMotDePasse($mail, $mdp);
            $this->addFlash('alert', "aucun utilisateur n'est enregistrer avec ce mail");
            return $this->redirectToRoute("identification");
        }
    }
    
    /**
     * 
     * @param type $nbrLettre le nombre de lettres
     * @return string 
     */
     public function textAleat($nbrLettre): string {
        $liste = array("A","B","C","D","E","F","G","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
        $mot = "";
        for ($k = 0; $k<$nbrLettre; $k++){
            $mot = $mot.$liste[rand(0,24)];
        }
        return $mot; 
    }
}
