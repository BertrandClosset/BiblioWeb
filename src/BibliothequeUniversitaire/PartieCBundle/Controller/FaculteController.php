<?php

namespace BibliothequeUniversitaire\PartieCBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use BibliothequeUniversitaire\EntiteBundle\Entity\Faculte;
use BibliothequeUniversitaire\PartieCBundle\Form\FaculteType;


class FaculteController extends Controller
{
    /**
     * Liste les différentes Facultés.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BibliothequeUniversitaireEntiteBundle:Faculte')->findAll();

        return $this->render('BibliothequeUniversitairePartieCBundle:Faculte:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Affiche le détail d'une Faculté.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BibliothequeUniversitaireEntiteBundle:Faculte')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de retrouver cette Faculté');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BibliothequeUniversitairePartieCBundle:Faculte:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
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
            ->setAction($this->generateUrl('partieC_faculte_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer'))
            ->getForm()
            ;
    }

    /**
     * Deletes a Faculte entity.
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
            $repository = $em->getRepository('BibliothequeUniversitaireEntiteBundle:Faculte');
            $entity = $repository->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Impossible de retrouver cette Faculté');
            }

            $repository->removeLecteurs($entity);
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('partieC_faculte_liste'));
    }

    /**
     * Displays a form to create a new Faculté entity.
     *
     */
    public function newAction()
    {
        $entity = new Faculte();
        $form   = $this->createCreateForm($entity);

        return $this->render('BibliothequeUniversitairePartieCBundle:Faculte:new.html.twig', array(
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
            'action' => $this->generateUrl('partieC_faculte_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Ajouter'));

        return $form;
    }

    /**
     * Creates a new Facilte entity.
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

            return $this->redirect($this->generateUrl('partieC_faculte_show', array('id' => $entity->getId())));
        }

        return $this->render('BibliothequeUniversitairePartieCBundle:Faculte:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
}