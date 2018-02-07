<?php

namespace BibliothequeUniversitaire\PartieCBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use BibliothequeUniversitaire\EntiteBundle\Entity\Reservation;
use BibliothequeUniversitaire\PartieCBundle\Form\ReservationType;

class ReservationController extends Controller
{
    /**
     * Deletes a Reservation entity.
     * @param $id
     * @param $idLecteur
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($id, $idLecteur)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BibliothequeUniversitaireEntiteBundle:Reservation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de retrouver cette réservation');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('partieC_lecteur_emprunt', array('idLecteur' => $idLecteur)));
    }

    public function newAction($idLivre)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $reservation = new Reservation();
        $livre = $em->getRepository("BibliothequeUniversitaireEntiteBundle:Livre")->find($idLivre);
        $dateRenduPlusTot = $em->getRepository("BibliothequeUniversitaireEntiteBundle:Emprunt")->findDateRenduPlusTot($livre);

        $lecteur = $em->getRepository("BibliothequeUniversitaireEntiteBundle:Lecteur")->find($user->getLecteurAssocie()->getId());

        if($em->getRepository("BibliothequeUniversitaireEntiteBundle:Lecteur")->limiteEmprunter($lecteur))
        {
            throw $this->createNotFoundException("Votre quota d'emprunts est dépassé.");
        }

        $form = $this->createCreateForm($reservation, $idLivre);

        return $this->render('BibliothequeUniversitairePartieCBundle:Reservation:new.html.twig', array(
            'livre' => $livre,
            'form'   => $form->createView(),
            'idLecteur' => $lecteur->getId(),
            'dateRenduPlusTot' => $dateRenduPlusTot,
        ));

    }

    /**
     * Creates a form to create a Reservation entity.
     *
     * @param Reservation $entity The entity
     *
     * @param $idLivre
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Reservation $entity, $idLivre)
    {
        $form = $this->createForm(new ReservationType(), $entity, array(
            'action' => $this->generateUrl('partieC_reservation_create', array('idLivre' => $idLivre)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Réserver'));

        return $form;
    }

    public function createAction(Request $request, $idLivre)
    {
        $user = $this->getUser();
        $entity = new Reservation();
        $form = $this->createCreateForm($entity, $idLivre);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $lecteur = $em->getRepository("BibliothequeUniversitaireEntiteBundle:Lecteur")->find($user->getLecteurAssocie()->getId());
            $livre = $em->getRepository("BibliothequeUniversitaireEntiteBundle:Livre")->find($idLivre);

            if ($em->getRepository("BibliothequeUniversitaireEntiteBundle:Emprunt")->findByLecteurAndLivre($lecteur, $livre))
            {
                throw $this->createNotFoundException("Emprunt de ce livre en cours");
            }

            $entity->setLivreReserve($livre);
            $entity->setLecteursReservant($lecteur);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('partieC_lecteur_emprunt', array('idLecteur' => $lecteur->getId())));
        }

        return $this->render('BibliothequeUniversitairePartieCBundle:Reservation:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
}