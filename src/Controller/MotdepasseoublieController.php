<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Entity\Mdpoublie;
use App\Entity\Utilisateur;
use App\Form\MotdepasseRegistrationFormType;
use App\Repository\MdpoublieRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
/**
 * Description of MotdepasseoublieController
 *
 * @author vielf
 */
class MotdepasseoublieController extends AbstractController {
    //put your code here
    
    
     function __construct() {
       
    }

    
    /**
     * @Route ("/modifie/motdepasse/{code}", name="modifie.motdepasse", methods={"GET","POST"})
     * 
     * @return Response
     */
    public function index(EntityManagerInterface $om, Request $request, $code, UtilisateurRepository $utilisateurRepository, MdpoublieRepository $mdpRepository, MailerInterface $mailer, UserPasswordEncoderInterface $passwordEncoder):Response {
        
        
        $form = $this->createForm(MotdepasseRegistrationFormType::class);
        $mdpOublie = new Mdpoublie;
        $mdpOublie = $mdpRepository->findOneByCode($code);
        if($mdpOublie != null){
        $mail = $mdpOublie->getMail();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $mdp = $form['motdepasse']->getData();
            $mdpOublie->setMdp($passwordEncoder->encodePassword($mdpOublie, $mdp));
            $utilisateurRepository->updateMotdepasse($mdpOublie->getMdp(), $mail);
            $this->addFlash('succes', 'mot de passe modifier avec succès');
            
            $om->remove($mdpOublie);
            $om->flush();
            
            $email = (new TemplatedEmail())
                    ->from('bagen@alwaysdata.net')
                    ->to($mail)
                    ->subject('Mot de passe modifié')
                    ->htmlTemplate("layouts/partials/_mailcontact.html.twig")
                    ->context([
                        'titre' => 'Mot de passe Modifié',
                        'message' => 'Votre mot de passe a bien été modifier nous vous invitons à vous connecter : http://localhost/bagen/public/index.php/identification',
                        'mail' => 'bagen@alwaysdata.net'
                    ]);
            $mailer->send($email);
            
            return $this->redirectToRoute('identification');
        }
        //return $this->redirectToRoute('modifie.motdepasse',['code'=>$code
            return $this->render("pages/motdepasseoublie.html.twig",[
            'registrationForm' => $form->createView()
        ]);
        //]);
        }else{
            return $this->redirectToRoute('identification');
        }
            
            
    }
    
   
    
}
