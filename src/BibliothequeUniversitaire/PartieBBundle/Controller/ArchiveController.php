<?php

namespace BibliothequeUniversitaire\PartieBBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use BibliothequeUniversitaire\EntiteBundle\Entity\Archive;


class ArchiveController extends Controller
{
    public function newAction($idEmprunt)
    {
        $em = $this->getDoctrine()->getManager();
        $archive = new Archive();
        $emprunt = $em->getRepository("BibliothequeUniversitaireEntiteBundle:Emprunt")->find($idEmprunt);

        $lecteur = $emprunt->getLecteurEmprunteur();
        $livre = $emprunt->getExemplaireEmprunte()->getLivresDupliques();

        $nomPrenom = $lecteur->getNom() . " " . $lecteur->getPrenom();
        $titreAuteur = $livre->getTitre();

        foreach ($livre->getAuteursInscrits() as $auteur)
        {
            $titreAuteur .= " - " . $auteur->getPrenom() . " " . $auteur->getNom();
        }

        $archive->setTitreAuteur($titreAuteur);
        $archive->setIdentiteLecteur($nomPrenom);
        $archive->setDateDebut($emprunt->getDateDebut());
        $archive->setDateRetour(new \DateTime());

        $em->remove($emprunt);
        $em->persist($archive);
        $em->flush();

        return $this->redirect($this->generateUrl('partieB_emprunt_lecteur_liste', array('id' => $lecteur->getId())));
    }
}