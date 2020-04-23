<?php

namespace App\Controller\Security;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $lastusername = $authenticationUtils->getLastUsername();
        $error = $authenticationUtils->getLastAuthenticationError();  
        return $this->render('security/login.html.twig', [
            'controller_name' => 'SecurityController',
            'lastusername' => $lastusername,
            'error' => $error
        ]);
    }
}
