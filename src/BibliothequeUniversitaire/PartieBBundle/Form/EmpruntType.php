<?php

namespace BibliothequeUniversitaire\PartieBBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EmpruntType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('lecteur_emprunteur');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BibliothequeUniversitaire\EntiteBundle\Entity\Emprunt'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bibliothequeuniversitaire_partieBbundle_emprunt';
    }

    public function getDefaultOptions(array $options){
        return array('data_class' => 'BibliothequeUniversitaire\EntiteBundle\Entity\Emprunt');
    }
}
