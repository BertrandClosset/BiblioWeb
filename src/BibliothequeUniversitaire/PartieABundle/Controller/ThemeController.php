<?php

namespace BibliothequeUniversitaire\PartieABundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use BibliothequeUniversitaire\EntiteBundle\Entity\Theme;
use BibliothequeUniversitaire\PartieABundle\Form\ThemeType;

/**
 * Theme controller.
 *
 */
class ThemeController extends Controller
{
    /**
     * Lists all Theme entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BibliothequeUniversitaireEntiteBundle:Theme')->findAll();

        return $this->render('BibliothequeUniversitairePartieABundle:Theme:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BibliothequeUniversitaireEntiteBundle:Theme')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de retrouver ce Thème');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BibliothequeUniversitairePartieABundle:Theme:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to delete a Theme entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('partieA_theme_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer'))
            ->getForm()
            ;
    }

    /**
     * Deletes a Theme entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BibliothequeUniversitaireEntiteBundle:Theme')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Impossible de retrouver ce Thème');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('partieA_theme_liste'));
    }

    /**
     * Displays a form to create a new Theme entity.
     *
     */
    public function newAction()
    {
        $entity = new Theme();
        $form   = $this->createCreateForm($entity);

        return $this->render('BibliothequeUniversitairePartieABundle:Theme:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Theme entity.
     *
     * @param Theme $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Theme $entity)
    {
        $form = $this->createForm(new ThemeType(), $entity, array(
            'action' => $this->generateUrl('partieA_theme_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Ajouter'));

        return $form;
    }

    /**
     * Creates a new Theme entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Theme();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('partieA_theme_show', array('id' => $entity->getId())));
        }

        return $this->render('BibliothequeUniversitairePartieABundle:Theme:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
}