<?php

namespace BibliothequeUniversitaire\PartieABundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use BibliothequeUniversitaire\EntiteBundle\Entity\Auteur;
use BibliothequeUniversitaire\EntiteBundle\Entity\Livre;
use BibliothequeUniversitaire\PartieABundle\Form\AuteurType;

class AuteurController extends Controller {

    /**
     * Liste les différents Auteurs.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BibliothequeUniversitaireEntiteBundle:Auteur')->findAll();

        return $this->render('BibliothequeUniversitairePartieABundle:Auteur:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Affiche le détail d'un Auteur.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BibliothequeUniversitaireEntiteBundle:Auteur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de retrouver cet Auteur');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BibliothequeUniversitairePartieABundle:Auteur:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to delete a Auteur entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('partieA_auteur_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer'))
            ->getForm()
            ;
    }

    /**
     * Deletes a Auteur entity.
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
            $entity = $em->getRepository('BibliothequeUniversitaireEntiteBundle:Auteur')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Impossible de retrouver cet Auteur');
            }

            $livres_ecrits = $entity->getLivresEcrits()->toArray();
            $repository = $em->getRepository("BibliothequeUniversitaireEntiteBundle:Livre");

            if ($repository->isManyAuteurs($livres_ecrits))
            {
                throw $this->createNotFoundException('Impossible de supprimer cet Auteur. Livres co-écrits trouvés.');
            }
            $repository->removeOneAuteur($livres_ecrits);

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('partieA_auteur_liste'));
    }

    /**
     * Displays a form to edit an existing Auteur entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BibliothequeUniversitaireEntiteBundle:Auteur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de retrouver cet Auteur');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BibliothequeUniversitairePartieABundle:Auteur:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Auteur entity.
     *
     * @param Auteur $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Auteur $entity)
    {
        $form = $this->createForm(new AuteurType(), $entity, array(
            'action' => $this->generateUrl('partieA_auteur_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Mettre à jour'));

        return $form;
    }

    /**
     * Edits an existing Auteur entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BibliothequeUniversitaireEntiteBundle:Auteur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de retrouver cet Auteur');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('partieA_auteur_show', array('id' => $id)));
        }

        return $this->render('BibliothequeUniversitairePartieABundle:Auteur:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to create a new Auteur entity.
     *
     */
    public function newAction()
    {
        $entity = new Auteur();
        $form   = $this->createCreateForm($entity);

        return $this->render('BibliothequeUniversitairePartieABundle:Auteur:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Auteur entity.
     *
     * @param Auteur $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Auteur $entity)
    {
        $form = $this->createForm(new AuteurType(), $entity, array(
            'action' => $this->generateUrl('partieA_auteur_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Ajouter'));

        return $form;
    }

    /**
     * Creates a new Auteur entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Auteur();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('partieA_auteur_show', array('id' => $entity->getId())));
        }

        return $this->render('BibliothequeUniversitairePartieABundle:Auteur:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
}