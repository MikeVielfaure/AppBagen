<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Form\ContacterRegistrationFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of ContactController
 *
 * @author vielf
 */
class ContactController extends AbstractController {
    //put your code here
    
    
     function __construct() {
       
    }

    
    /**
     * @Route ("/contact", name="contact", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function index(Request $request, MailerInterface $mailer):Response {
        //$this->denyAccessUnlessGranted('ROLE_USER');
        
        $form = $this->createForm(ContacterRegistrationFormType::class);
        
        $contact = $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $email = (new TemplatedEmail())
                    ->from('bagen@alwaysdata.net')
                    ->to("vielfauremike@gmail.com")
                    ->subject($contact->get('titre')->getData())
                    ->htmlTemplate("layouts/partials/_mailcontact.html.twig")
                    ->context([
                        'titre' => $contact->get('titre')->getData(),
                        'message' => $contact->get('message')->getData(),
                        'mail' => $contact->get('email')->getData()
                    ]);
            $mailer->send($email);
            $this->addFlash('message','Votre e-mail a bien été envoyé ');
            
            return $this->redirectToRoute('contact');
           
        }
        
        return $this->render("pages/contact.html.twig", [
            'form' => $form->createView()
        ]);
    }
   
    
}

