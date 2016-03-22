<?php

namespace AppBundle\Form\Event;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EventRoleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('event')
            ->add('name')
            //->add('description')
            //->add('requiredResponsabilities')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Event\EventRole',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_event_eventrole';
    }
}
