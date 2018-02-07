<?php

namespace BibliothequeUniversitaire\PartieBBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use BibliothequeUniversitaire\EntiteBundle\Entity\Emprunt;
use BibliothequeUniversitaire\PartieBBundle\Form\EmpruntType;
use Symfony\Component\Validator\Constraints\DateTime;


class EmpruntController extends Controller
{
    /**
     * Liste les différents Emprunts
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BibliothequeUniversitaireEntiteBundle:Emprunt')->findAllSortByLecteur();

        return $this->render('BibliothequeUniversitairePartieBBundle:Emprunt:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    public function listeLecteurAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $lecteur = $em->getRepository("BibliothequeUniversitaireEntiteBundle:Lecteur")->find($id);
        $cycle = $lecteur->getCycleChoisi();

        $emprunts = $em->getRepository('BibliothequeUniversitaireEntiteBundle:Emprunt')->findByLecteur($lecteur);
        $reservations = $em->getRepository('BibliothequeUniversitaireEntiteBundle:Reservation')->findByLecteur($lecteur);
        $nombreLivres = $em->getRepository('BibliothequeUniversitaireEntiteBundle:Emprunt')->countLivreEmprunt($lecteur);

        return $this->render('BibliothequeUniversitairePartieBBundle:Emprunt:listeLecteur.html.twig', array(
            'emprunts' => $emprunts,
            'cycle' => $cycle,
            'nombreLivres' => $nombreLivres,
            'lecteur' => $lecteur,
            'reservations' => $reservations,
        ));
    }

    public function listeLivresAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $livre = $em->getRepository("BibliothequeUniversitaireEntiteBundle:Livre")->find($id);

        if (!$livre)
        {
            throw $this->createNotFoundException("Livre inexistant");
        }

        $emprunts = $em->getRepository("BibliothequeUniversitaireEntiteBundle:Emprunt")->findAllByLivre($livre);
        $dispo = $em->getRepository("BibliothequeUniversitaireEntiteBundle:Livre")->isDisponible($livre);
        $nombreDispo = $em->getRepository("BibliothequeUniversitaireEntiteBundle:Livre")->countLivreDispo($livre);

        return $this->render('BibliothequeUniversitairePartieBBundle:Emprunt:listeLivres.html.twig', array(
            'entities' => $emprunts,
            'livre'    => $livre,
            'dispo'    => $dispo,
            'nombreDispo' => $nombreDispo,
        ));

    }

    public function listeRetardAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BibliothequeUniversitaireEntiteBundle:Emprunt')->findAllSortByLecteur();

        return $this->render('BibliothequeUniversitairePartieBBundle:Emprunt:listeRetard.html.twig', array(
            'entities' => $entities,
        ));
    }

    public function newAction($idLivre)
    {
        $em = $this->getDoctrine()->getManager();
        $livre = $em->getRepository("BibliothequeUniversitaireEntiteBundle:Livre")->find($idLivre);

        $emprunt = new Emprunt();

        $form = $this->createCreateForm($emprunt, $livre->getId());

        return $this->render('BibliothequeUniversitairePartieBBundle:Emprunt:new.html.twig', array(
            'form'   => $form->createView(),
            'livre'  => $livre,
        ));
    }

    public function reservToempruntAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $reservation = $em->getRepository("BibliothequeUniversitaireEntiteBundle:Reservation")->find($id);

        $emprunt = new Emprunt();

        $form = $this->createCreateReservForm($emprunt, $reservation->getLivreReserve()->getId());

        $form->handleRequest($request);

        if ($form->isValid())
        {
            $emprunt->setDateDebut(new \DateTime());
            $emprunt->setLecteurEmprunteur($reservation->getLecteursReservant());
            $em->persist($emprunt);
            $em->remove($reservation);
            $em->flush();

            return $this->redirect($this->generateUrl('partieB_emprunt_lecteur_liste', array('id' => $reservation->getLecteursReservant()->getId())));
        }
        return $this->render('BibliothequeUniversitairePartieBBundle:Emprunt:reservEmprunt.html.twig', array(
            'form'   => $form->createView(),
            'livre'  => $reservation->getLivreReserve(),
        ));
    }

    /**
     * Creates a form to create a Emprunt entity.
     *
     * @param Emprunt $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Emprunt $entity, $idLivre)
    {
        $em = $this->getDoctrine()->getManager();

        $livre = $em->getRepository("BibliothequeUniversitaireEntiteBundle:Livre")->find($idLivre);
        $exemplaires = $em->getRepository("BibliothequeUniversitaireEntiteBundle:Livre")->findExemplairesDispo($livre);

        $form = $this->createForm(new EmpruntType(), $entity, array(
            'action' => $this->generateUrl('partieB_emprunt_create', array('idLivre' => $idLivre)),
            'method' => 'POST',
        ));

        $form->add('exemplaire_emprunte', 'entity', array(
            'class' => 'BibliothequeUniversitaireEntiteBundle:Exemplaire',
            'query_builder' => function($repository) use ($livre) {
                return $repository->findExemplairesDispo($livre);
            }));

        $form->add('submit', 'submit', array('label' => 'Emprunter'));

        return $form;
    }

    private function createCreateReservForm(Emprunt $entity, $idLivre)
    {
        $em = $this->getDoctrine()->getManager();

        $livre = $em->getRepository("BibliothequeUniversitaireEntiteBundle:Livre")->find($idLivre);
        $exemplaires = $em->getRepository("BibliothequeUniversitaireEntiteBundle:Livre")->findExemplairesDispo($livre);

        $form = $this->createFormBuilder($entity);

        $form->add('exemplaire_emprunte', 'entity', array(
            'class' => 'BibliothequeUniversitaireEntiteBundle:Exemplaire',
            'query_builder' => function($repository) use ($livre) {
                return $repository->findExemplairesDispo($livre);
            }));

        $form->add('submit', 'submit', array('label' => 'Emprunter'));

        return $form->getForm();
    }

    public function createAction(Request $request, $idLivre)
    {
        $entity = new Emprunt();
        $form = $this->createCreateForm($entity, $idLivre);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $livre = $em->getRepository("BibliothequeUniversitaireEntiteBundle:Livre")->find($idLivre);
        if ($form->isValid()) {
            $lecteur = $entity->getLecteurEmprunteur();
            $livreEmprunte = $entity->getExemplaireEmprunte()->getLivresDupliques();

            if($em->getRepository("BibliothequeUniversitaireEntiteBundle:Emprunt")->findByLecteurAndLivre($lecteur, $livreEmprunte))
            {
                throw $this->createNotFoundException("Vous avez déjà un emprunt en cours sur ce livre");
            }

            if ($em->getRepository("BibliothequeUniversitaireEntiteBundle:Lecteur")->limiteEmprunter($lecteur))
            {
                throw $this->createNotFoundException("Vous avez dépassé votre quota d'emprunt");
            }

            $reservations = $em->getRepository("BibliothequeUniversitaireEntiteBundle:Reservation")->findByLivre($livreEmprunte);
            $nombreDispo = $em->getRepository("BibliothequeUniversitaireEntiteBundle:Livre")->countLivreDispo($livreEmprunte);

            if($em->getRepository("BibliothequeUniversitaireEntiteBundle:Reservation")->findByLecteurAndLivre($lecteur, $livreEmprunte))
            {
                throw $this->createNotFoundException("Livre déjà en cours de réservation par ce lecteur");
            }

            if (!$em->getRepository("BibliothequeUniversitaireEntiteBundle:Emprunt")->checkDispoByLecteur($reservations, $lecteur, $nombreDispo))
            {
                throw $this->createNotFoundException("Livre non disponible à l'emprunt - Réservation en cours");
            }

            $entity->setDateDebut(new \DateTime());
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('partieB_emprunt_livre_liste', array('id' => $idLivre)));
        }

        return $this->render('BibliothequeUniversitairePartieBBundle:Emprunt:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'livre'  => $livre,
        ));
    }
}