<?php

namespace BibliothequeUniversitaire\PartieCBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use BibliothequeUniversitaire\EntiteBundle\Entity\Lecteur;
use BibliothequeUniversitaire\PartieCBundle\Form\LecteurType;


class LecteurController extends Controller
{
    /**
     * Liste les différents Lecteurs.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BibliothequeUniversitaireEntiteBundle:Lecteur')->findAll();

        $form = $this->createSearchForm();
        $request = $this->get('request');

        if($request->getMethod() == 'POST')
        {
            $form->submit($request->request->get($form->getName()));
            if($form->isValid())
            {
                $data = $form->getData();
                $listeLecteurs= $em->getRepository('BibliothequeUniversitaireEntiteBundle:Lecteur')->searchLecteurs($data);

                return $this->render('BibliothequeUniversitairePartieCBundle:Lecteur:search.html.twig', array(
                    'listeLecteurs' => $listeLecteurs
                ));
            }
        }

        return $this->render('BibliothequeUniversitairePartieCBundle:Lecteur:index.html.twig', array(
            'form'     => $form->createView(),
            'entities' => $entities,
        ));
    }

    /**
     * Affiche le détail d'un Lecteur.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BibliothequeUniversitaireEntiteBundle:Lecteur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de retrouver ce Lecteur');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BibliothequeUniversitairePartieCBundle:Lecteur:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to delete a Lecteur entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('partieC_lecteur_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer'))
            ->getForm()
            ;
    }

    /**
     * Deletes a Lecteur entity.
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BibliothequeUniversitaireEntiteBundle:Lecteur')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Impossible de retrouver ce Lecteur');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('partieC_lecteur_liste'));
    }

    /**
     * Displays a form to create a new Lecteur entity.
     *
     */
    public function newAction()
    {
        $entity = new Lecteur();
        $form   = $this->createCreateForm($entity);

        return $this->render('BibliothequeUniversitairePartieCBundle:Lecteur:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Lecteur entity.
     *
     * @param Lecteur $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Lecteur $entity)
    {
        $form = $this->createForm(new LecteurType(), $entity, array(
            'action' => $this->generateUrl('partieC_lecteur_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Ajouter'));

        return $form;
    }

    /**
     * Creates a new Lecteur entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Lecteur();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('partieC_lecteur_show', array('id' => $entity->getId())));
        }

        return $this->render('BibliothequeUniversitairePartieCBundle:Lecteur:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Lecteur entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BibliothequeUniversitaireEntiteBundle:Lecteur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de retrouver ce Lecteur');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BibliothequeUniversitairePartieCBundle:Lecteur:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function empruntAction($idLecteur)
    {
        $em = $this->getDoctrine()->getManager();

        $lecteur = $em->getRepository("BibliothequeUniversitaireEntiteBundle:Lecteur")->find($idLecteur);
        $cycle = $lecteur->getCycleChoisi();

        $emprunts = $em->getRepository('BibliothequeUniversitaireEntiteBundle:Emprunt')->findByLecteur($lecteur);
        $nombreLivres = $em->getRepository('BibliothequeUniversitaireEntiteBundle:Emprunt')->countLivreEmprunt($lecteur);
        $reservations = $em->getRepository('BibliothequeUniversitaireEntiteBundle:Reservation')->findByLecteur($lecteur);

        return $this->render('BibliothequeUniversitairePartieCBundle:Lecteur:emprunt.html.twig', array(
            'emprunts' => $emprunts,
            'reservations' => $reservations,
            'cycle' => $cycle,
            'idLecteur' => $idLecteur,
            'nombreLivres' => $nombreLivres,
        ));
    }

    /**
     * Creates a form to edit a Lecteur entity.
     *
     * @param Lecteur $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Lecteur $entity)
    {
        $form = $this->createForm(new LecteurType(), $entity, array(
            'action' => $this->generateUrl('partieC_lecteur_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Mettre à jour'));

        return $form;
    }

    /**
     * Edits an existing Lecteur entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BibliothequeUniversitaireEntiteBundle:Lecteur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de retrouver ce Lecteur');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('partieC_lecteur_show', array('id' => $id)));
        }

        return $this->render('BibliothequeUniversitairePartieABundle:Auteur:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to search a Lecteur entity by Nom
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createSearchForm()
    {
        return $this->createFormBuilder()
            ->add('nom', 'text', array(
                'required' => true
            ))
            ->getForm();
    }


}