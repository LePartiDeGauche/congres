<?php

namespace AppBundle\Form\Election;

use AppBundle\Entity\AdherentRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DepartmentalElectionType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array('label' => 'Nom du rapporteur', 'required' => true))
            ->add('organ', null, array('label' => 'Comité', 'required' => true))
            ->add('date', null, array('label' => "Date de l'élection"))
            ->add('numberOfVoters', null, array('label' => 'Nombre de votants', 'required' => false))
            ->add('validVotes', null, array('label' => 'Votes exprimés', 'required' => false))
            ->add('blankVotes', null, array('label' => 'Votes blancs', 'required' => false))
            ->add('coSecWomen', 'entity', array(
                'label' => 'Co-secrétaire femme', 'required' => true,
                'expanded' => false,
                'multiple' => false,
                'class' => 'AppBundle\Entity\Adherent',
                'query_builder' => function (AdherentRepository $repository) {
                    return $repository->findByDepartement(59);
                }
            ))
            ->add('oldCoSecWomen', null, array('label' => 'Ancienne co-secrétaire femme', 'required' => false))
            ->add('coSecMen', null, array('label' => 'Co-secrétaire homme', 'required' => true))
            ->add('oldCoSecMen', null, array('label' => 'Ancien co-secrétaire homme', 'required' => false))
            ->add('coTreasureWomen', null, array('label' => 'Co-trésorière femme', 'required' => true))
            ->add('oldCoTreasureWomen', null, array('label' => 'Ancienne co-trésorière femme', 'required' => false))
            ->add('coTreasureMen', null, array('label' => 'Co-trésorière homme', 'required' => true))
            ->add('oldCoTreasureMen', null, array('label' => 'Ancien co-trésorier homme', 'required' => false))
            ->add('responsability1', null, array('label' => 'Poste fonctionnel', 'required' => false))
            ->add('responsability2', null, array('label' => 'Poste fonctionnel', 'required' => false))
            ->add('responsability3', null, array('label' => 'Poste fonctionnel', 'required' => false))
            ->add('responsability4', null, array('label' => 'Poste fonctionnel', 'required' => false))
            ->add('responsability5', null, array('label' => 'Poste fonctionnel', 'required' => false))
            ->add('responsability6', null, array('label' => 'Poste fonctionnel', 'required' => false))


        ;
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return 'appbundle_election_election';
    }
}