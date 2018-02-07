<?php

namespace BibliothequeUniversitaire\EntiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ThemeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle')
            ->add('description')
            ->add('livres_associes')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BibliothequeUniversitaire\EntiteBundle\Entity\Theme'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bibliothequeuniversitaire_entitebundle_theme';
    }
}
