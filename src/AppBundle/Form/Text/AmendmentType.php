<?php

namespace AppBundle\Form\Text;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AmendmentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startLine')
            ->add('type', 'choice', array(
        'choices' => array('a' => 'Ajout', 'd' => 'Suppression', 'm' => 'Modification'), ))
            ->add('content')
            ->add('text')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Text\Amendment',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_text_amendment';
    }
}
