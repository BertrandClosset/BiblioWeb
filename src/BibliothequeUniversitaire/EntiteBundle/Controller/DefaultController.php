<?php

namespace BibliothequeUniversitaire\EntiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('bibliotheque_universitaire_menu'));
    }

    public function menuAction()
    {
        $user = $this->getUser();

        if(true === $this->get('security.authorization_checker')->isGranted('ROLE_LECTEUR'))
        {
            return $this->redirect($this->generateUrl('partieC_lecteur_emprunt', array(
                'idLecteur' => $user->getLecteurAssocie()->getId(),
            )));
        }

        $chaineRoles = '';
        foreach ($user->getRoles() as $groupe)
        {
            $chaineRoles .= ' ' . $groupe;
        }

        return $this->render('BibliothequeUniversitaireEntiteBundle:Default:menu.html.twig', array(
            'roles' => $chaineRoles,
        ));
    }
}
