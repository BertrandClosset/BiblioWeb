<?php

namespace BibliothequeUniversitaire\EntiteBundle\Form;

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
            ->add('faculte_choisie')
            ->add('cycle_choisi')
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
        return 'bibliothequeuniversitaire_entitebundle_lecteur';
    }
}
