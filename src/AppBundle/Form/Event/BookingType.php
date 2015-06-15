<?php

namespace AppBundle\Form\Event;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BookingType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', 'date', array('label' => 'Date de première nuit'))
            ->add('duration', 'integer', array('label' => 'Nombre de nuits'))
            ->add('save', 'submit', array('label' => 'Enregistrer'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'appbundle_event_booking';
    }
}