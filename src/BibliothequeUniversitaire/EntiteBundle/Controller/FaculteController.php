<?php

namespace BibliothequeUniversitaire\EntiteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use BibliothequeUniversitaire\EntiteBundle\Entity\Faculte;
use BibliothequeUniversitaire\EntiteBundle\Form\FaculteType;

/**
 * Faculte controller.
 *
 */
class FaculteController extends Controller
{

    /**
     * Lists all Faculte entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BibliothequeUniversitaireEntiteBundle:Faculte')->findAll();

        return $this->render('BibliothequeUniversitaireEntiteBundle:Faculte:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Faculte entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Faculte();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('faculte_show', array('id' => $entity->getId())));
        }

        return $this->render('BibliothequeUniversitaireEntiteBundle:Faculte:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Faculte entity.
     *
     * @param Faculte $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Faculte $entity)
    {
        $form = $this->createForm(new FaculteType(), $entity, array(
            'action' => $this->generateUrl('faculte_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Faculte entity.
     *
     */
    public function newAction()
    {
        $entity = new Faculte();
        $form   = $this->createCreateForm($entity);

        return $this->render('BibliothequeUniversitaireEntiteBundle:Faculte:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Faculte entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BibliothequeUniversitaireEntiteBundle:Faculte')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Faculte entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BibliothequeUniversitaireEntiteBundle:Faculte:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Faculte entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BibliothequeUniversitaireEntiteBundle:Faculte')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Faculte entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BibliothequeUniversitaireEntiteBundle:Faculte:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Faculte entity.
    *
    * @param Faculte $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Faculte $entity)
    {
        $form = $this->createForm(new FaculteType(), $entity, array(
            'action' => $this->generateUrl('faculte_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Faculte entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BibliothequeUniversitaireEntiteBundle:Faculte')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Faculte entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('faculte_edit', array('id' => $id)));
        }

        return $this->render('BibliothequeUniversitaireEntiteBundle:Faculte:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Faculte entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BibliothequeUniversitaireEntiteBundle:Faculte')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Faculte entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('faculte'));
    }

    /**
     * Creates a form to delete a Faculte entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('faculte_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
