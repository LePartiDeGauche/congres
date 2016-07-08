<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use AppBundle\Entity\Adherent;

class AdherentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('lastname', 'text', array('label' => 'Nom'))
                ->add('firstname', 'text', array('label' => 'Prénom'))
                ->add('gender', 'choice', array(
                    'choices' => array(Adherent::GENDER_MALE => 'Homme', Adherent::GENDER_FEMALE => 'Femme'),
                    'label'   => 'Genre'
                ))
                ->add('birthdate', 'birthday', array('label' => 'Date de naissance'))
                ->add('mobilephone', 'text', array('label' => 'Téléphone'))
                ->add('departement', 'integer', array('label' => 'Code département'))
                ->add('save', 'submit', array('label' => 'Enregistrer'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Adherent',
        ));
    }

    public function getName()
    {
        return 'app_adherent';
    }
}
