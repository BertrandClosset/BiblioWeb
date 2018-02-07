<?php

namespace BibliothequeUniversitaire\PartieABundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LivreType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('notice')
            ->add('nombreExemplaires')
            ->add('auteurs_inscrits', 'entity', array(
                'multiple' => true,
                'class' => 'BibliothequeUniversitaireEntiteBundle:Auteur',
                'query_builder' => function($repository) {
                    return $repository->createQueryBuilder('a')->orderBy('a.prenom', 'ASC')->addOrderBy('a.nom', 'ASC');
                }))
            ->add('themes_associes', 'entity', array(
                'multiple' => true,
                'class' => 'BibliothequeUniversitaireEntiteBundle:Theme',
                'query_builder' => function($repository) {
                    return $repository->createQueryBuilder('t')->orderBy('t.libelle', 'ASC');
                }))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BibliothequeUniversitaire\EntiteBundle\Entity\Livre'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bibliothequeuniversitaire_entitebundle_livre';
    }
}
