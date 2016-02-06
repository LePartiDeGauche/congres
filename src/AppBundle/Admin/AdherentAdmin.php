<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Adherent;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBUndle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class AdherentAdmin extends Admin
{
    protected $baseRouteName = 'adherents';
    protected $baseRoutePattern = 'adherents';

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('lastname', null, array('label' => 'Nom'))
            ->add('firstname', null, array('label' => 'Prénom'))
            ->add('gender', 'choice', array(
                'label' => 'Genre',
                'choices' => Adherent::getGenderValues(),
            ))
            ->add('email')
            ->add('mobilephone', null, array('label' => 'Téléphone'))
            ->add('departement')
            ->add('birthdate', 'sonata_type_date_picker', array(
                'label' => 'Date de naissance',
                'format' => 'd/M/y',
            ))
            ->add('status', 'choice', array(
                'label' => 'Statut',
                'choices' => Adherent::getStatusValues(),
                'multiple' => false,
            ))
            ->add('organParticipations', 'sonata_type_collection', array(
                    'label' => 'Organes',
                    'by_reference' => false,
                ), array(
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'position',
                ), array(
                    'required' => false,
                )
            )
            ->add('responsabilities', 'sonata_type_collection',
                array(
                    'label' => 'Responsabilités (ces modifications seront écrasé à chaque nouvel import du TGF !)',
                    'by_reference' => false,
                ), array(
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'position',
                ), array(
                    'required' => false,
                )
            )
            ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('lastname', null, array('label' => 'Nom'))
            ->add('firstname', null, array('label' => 'Prénom'))
            ->add('email')
            ->add('birthdate', null, array('label' => 'Date de naissance'))
            ->add('status', null, array('label' => 'Statut'), 'choice', array(
                'choices' => array(
                    Adherent::STATUS_OK => 'À jour.',
                    Adherent::STATUS_ATTENTE_RENOUVELLEMENT => 'En attente.',
                    Adherent::STATUS_OLD => 'Ancien adhérent',
                    Adherent::STATUS_EXCLUDED => 'Exclusion',
                ),
                'multiple' => false,
            ))
            ->add('responsabilities.responsability', null, array('label' => 'Responsabilité', 'multiple' => true));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('email')
            ->addIdentifier('lastname', null, array('label' => 'Nom'))
            ->addIdentifier('firstname', null, array('label' => 'Prénom'))
            ->add('gender', null, array('label' => 'Genre'))
            ->add('birthdate', null, array('label' => 'Date de naissance'))
            ->add('user', null, array('label' => 'Compte'))
            ->add('status', null, array('Statut'))
            ->add('responsabilities', 'sonata_type_collection', array('associated_property' => 'responsability', 'label' => 'Responsabilités'))
            ->add('organParticipations', 'sonata_type_collection', array('associated_property' => 'organ', 'label' => 'Instances'));
    }
}
