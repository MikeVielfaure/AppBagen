<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Security;

use App\Controller\IdentificationController;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\AuthenticatorInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\PasswordUpgradeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use function dd;

/**
 * Description of LoginFormAuthenticator
 *
 * @author vielf
 */
class LoginFormAuthenticator extends AbstractAuthenticator{
   
    /**
     *
     * @var UtilisateurRepository
     */
    private $utilisateurRepository;
    
    /**
     *
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;
    
    
    function __construct(UtilisateurRepository $utilisateurRepository, UrlGeneratorInterface $urlGenerator) {
      $this->utilisateurRepository = $utilisateurRepository; 
      $this->urlGenerator = $urlGenerator;
      //dd($utilisateurRepository);
    }

      
    public function authenticate(Request $request): PassportInterface {
        //dd($request->request->get('mail'));
        $utilisateur = $this->utilisateurRepository->findOneByEmail($request->request->get('mail'));
        
        $request->getSession()->set(IdentificationController::OLD_MAIL, $request->request->get('mail'));
        
        if(!$utilisateur){
            throw new CustomUserMessageAuthenticationException('invalid credentials');
        }
        
        return new Passport($utilisateur, new PasswordCredentials($request->request->get('password')),[
            new CsrfTokenBadge('login_form', $request->request->get('csrf_token')),
            new RememberMeBadge
        ]);
        
        /**
        return new Passport($utilisateur, new PasswordCredentials($request->request->get('mdp')),[
            new CsrfTokenBadge('login_form', $request->request->get('csrf_token')),
            
            new PasswordUpgradeBadge($request->request->get('mdp'),$this->utilisateurRepository)
        ]);*/
    }

   

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response {
        //dd($exception);
        
        $request->getSession()->getFlashBag()->add('error','invalidate credentials');
        return new RedirectResponse($this->urlGenerator->generate('identification'));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response {
        //dd('succes');
        $request->getSession()->remove(IdentificationController::OLD_MAIL);
        //$request->getSession()->getFlashBag()->add('succes','login succesfuly');
        return new RedirectResponse($this->urlGenerator->generate('accueil.utilisateur'));
    }

    public function supports(Request $request): ?bool {
        //dd('cool');
        // vérifie que la route est celle de l'identification et que le requete est post
        return $request->attributes->get('_route') === 'identification'
                && $request->isMethod('POST');
    }

}
