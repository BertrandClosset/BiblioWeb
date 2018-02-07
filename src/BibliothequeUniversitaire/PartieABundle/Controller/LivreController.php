<?php

namespace BibliothequeUniversitaire\PartieABundle\Controller;

use BibliothequeUniversitaire\EntiteBundle\Entity\Exemplaire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use BibliothequeUniversitaire\EntiteBundle\Entity\Livre;
use BibliothequeUniversitaire\PartieABundle\Form\LivreType;


/**
 * Livre controller.
 *
 */
class LivreController extends Controller
{

    /**
     * Lists all Livre entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('BibliothequeUniversitaireEntiteBundle:Livre')->findAll();

        return $this->render('BibliothequeUniversitairePartieABundle:Livre:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a form to create a Livre entity.
     *
     * @param Livre $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Livre $entity)
    {
        $form = $this->createForm(new LivreType(), $entity, array(
            'action' => $this->generateUrl('partieA_livre_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Ajouter'));

        return $form;
    }

    /**
     * Displays a form to create a new Livre entity.
     *
     */
    public function newAction()
    {
        $entity = new Livre();
        $form   = $this->createCreateForm($entity);

        return $this->render('BibliothequeUniversitairePartieABundle:Livre:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    public function searchAction()
    {
        $form = $this->createSearchForm();
        $request = $this->get('request');

        if($request->getMethod() == 'POST')
        {
            $form->submit($request->request->get($form->getName()));
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $data = $form->getData();

                $listeLivres = $em->getRepository('BibliothequeUniversitaireEntiteBundle:Livre')->searchLivres($data);

                return $this->render('BibliothequeUniversitairePartieABundle:Livre:search.html.twig', array(
                    'listeLivres' => $listeLivres
                ));
            }
        }

        return $this->render('BibliothequeUniversitairePartieABundle:Livre:searchForm.html.twig', array(
            'form'     => $form->createView(),
        ));
    }

    /**
     * Creates a new Livre entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Livre();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $exemplaireRepository = $this->getDoctrine()
                                         ->getManager()
                                         ->getRepository('BibliothequeUniversitaireEntiteBundle:Exemplaire');

            $arrayCote = $exemplaireRepository->generateCote($entity->getNombreExemplaires());

            for($i = 0; $i < $entity->getNombreExemplaires(); $i++)
            {
                $exemplaire = new Exemplaire();
                $exemplaire->setLivresDupliques($entity);
                $exemplaire->setCote($arrayCote[$i]);

                $em->persist($exemplaire);
                $em->flush();
            }

            return $this->redirect($this->generateUrl('partieA_livre_show', array('id' => $entity->getId())));
        }

        return $this->render('BibliothequeUniversitairePartieABundle:Livre:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Livre entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BibliothequeUniversitaireEntiteBundle:Livre')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de retrouver ce Livre');
        }

        $dispo = $em->getRepository('BibliothequeUniversitaireEntiteBundle:Livre')->isDisponible($entity);

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BibliothequeUniversitairePartieABundle:Livre:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'dispo'       => $dispo,
        ));
    }

    /**
     * Deletes a Livre entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BibliothequeUniversitaireEntiteBundle:Livre')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Impossible de retrouver ce Livre');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('partieA_livre_liste'));
    }

    /**
     * Creates a form to delete a Livre entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('partieA_livre_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer'))
            ->getForm()
            ;
    }

    /**
     * Displays a form to edit an existing Livre entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BibliothequeUniversitaireEntiteBundle:Livre')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de retrouver ce Livre');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BibliothequeUniversitairePartieABundle:Livre:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Livre entity.
     *
     * @param Livre $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Livre $entity)
    {
        $form = $this->createForm(new LivreType(), $entity, array(
            'action' => $this->generateUrl('partieA_livre_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Mettre à jour'));

        return $form;
    }
    /**
     * Edits an existing Livre entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BibliothequeUniversitaireEntiteBundle:Livre')->find($id);
        $oldNombreExemplaires = $entity->getNombreExemplaires();

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de retrouver ce Livre');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            if ($entity->getNombreExemplaires() < $oldNombreExemplaires)
            {
                $differenceExemplaire = $oldNombreExemplaires - $entity->getNombreExemplaires();

                $exemplaireRepository = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('BibliothequeUniversitaireEntiteBundle:Exemplaire');

                for ($i = 1; $i <= $differenceExemplaire; $i++)
                {
                    $exemplaireRepository->deleteOneExemplairesByLivre($entity);
                }


            } elseif ($entity->getNombreExemplaires() > $oldNombreExemplaires) {
                $differenceExemplaire = $entity->getNombreExemplaires() - $oldNombreExemplaires;

                $exemplaireRepository = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('BibliothequeUniversitaireEntiteBundle:Exemplaire');

                $arrayCote = $exemplaireRepository->generateCote($entity->getNombreExemplaires());
                $compteurCote = 0;
                $oldExemplaires = $entity->getExemplairesProduits();

                foreach ($oldExemplaires as $exemplaire)
                {
                    $exemplaire->setCote($arrayCote[$compteurCote]);
                    $compteurCote++;
                }

                for($i = 0; $i < $differenceExemplaire; $i++)
                {
                        $exemplaire = new Exemplaire();
                        $exemplaire->setLivresDupliques($entity);
                        $exemplaire->setCote($arrayCote[$compteurCote]);
                        $compteurCote++;

                        $em->persist($exemplaire);
                }

                $em->flush();
            }

            return $this->redirect($this->generateUrl('partieA_livre_show', array('id' => $id)));
        }

        return $this->render('BibliothequeUniversitairePartieABundle:Livre:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to search a Livre entity by Auteur, Titre et Thème
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createSearchForm()
    {
        $listeThemes = $this
            ->getDoctrine()
            ->getRepository("BibliothequeUniversitaireEntiteBundle:Theme")
            ->findAlltoArray();

        return $this->createFormBuilder()
            ->add('titre', 'text', array(
                'required' => false
            ))
            ->add('auteur', 'text', array(
                'required' => false
            ))
            ->add('theme', 'choice', array(
                'choices'  => $listeThemes,
                'required' => false,
                'multiple' => true,
                'expanded' => true
            ))
            ->getForm();
    }
}
