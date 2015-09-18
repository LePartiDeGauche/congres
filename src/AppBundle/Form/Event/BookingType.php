<?php

namespace AppBundle\Form\Event;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

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
           /*
           Uncomment theses lines to modify the price scale
           ->add('price', 'choice', array(
                'choices'   => array(
                    '10' => 'Moins de 500 euros',
                    '20' => 'Entre 500 et 1000 euros',
                    '30' => 'Entre 1000 et 1500 euros',
                    '40' => 'Entre 1500 et 2000 euros',
                    '50' => 'Entre 2000 et 2500 euros',
                    '60' => 'Entre 2500 et 3000 euros',
                    '70' => 'Plus de 3000 euros'
                ),
                'required' => true,
                'multiple'  => false,
            ))*/
            ->add('save', 'submit', array('label' => 'Réserver'))
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
