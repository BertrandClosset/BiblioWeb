<?php

namespace BibliothequeUniversitaire\SecurityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {
        $session = $request->getSession();
        if($request->attributes->has(Security::AUTHENTICATION_ERROR))
            $error = $request->attributes->get(Security::AUTHENTICATION_ERROR);
        else {
            $error = $session->get(Security::AUTHENTICATION_ERROR);
            $session->remove(Security::AUTHENTICATION_ERROR);
        }

        return $this->render('BibliothequeUniversitaireSecurityBundle:Security:login.html.twig', array(
            'last_username' => $session->get(Security::LAST_USERNAME),
            'error'         => $error,
        ));
    }
}
