<?php

namespace BibliothequeUniversitaire\PartieCBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LecteurType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('faculte_choisie', 'entity', array(
                'class' => 'BibliothequeUniversitaireEntiteBundle:Faculte',
                'empty_value' => false,
                'query_builder' => function($repository) {
                    return $repository->createQueryBuilder('f')->orderBy('f.nom', 'ASC');
                }))
            ->add('cycle_choisi', 'entity', array(
                'class' => 'BibliothequeUniversitaireEntiteBundle:Cycle',
                'empty_value' => false,
                'query_builder' => function($repository) {
                    return $repository->createQueryBuilder('c')->orderBy('c.libelle', 'ASC');
                }))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BibliothequeUniversitaire\EntiteBundle\Entity\Lecteur'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bibliothequeuniversitaire_partieCbundle_lecteur';
    }
}
