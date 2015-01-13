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
        $roles = $this
            ->getConfigurationPool()
            ->getContainer()
            ->getParameter('security.role_hierarchy.roles');

        $formMapper
            ->add('email')
            ->add('lastname', null, array('label' => 'Nom'))
            ->add('firstname', null, array('label' => 'Prénom'))
            ->add('birthdate', 'birthday', array('label' => 'Date de naissance'));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('email')
            ->add('lastname', null, array('label' => 'Nom'))
            ->add('firstname', null, array('label' => 'Prénom'))
            ->add('birthdate', null, array('label' => 'Date de naissance'))
            ->add('status', null, array('label' => 'Statut'), 'choice', array(
                'choices' => array(
                    Adherent::STATUS_OK => 'À jour.',
                    Adherent::STATUS_ATTENTE_RENOUVELLEMENT => 'En attente.',
                ),
                'multiple' => false,
            ))
            ->add('instances', null, array(), null, array('property' => 'name'));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('email')
            ->addIdentifier('lastname', null, array('label' => 'Nom'))
            ->addIdentifier('firstname', null, array('label' => 'Prénom'))
            ->add('birthdate', null, array('label' => 'Date de naissance'))
            ->add('user', null, array('label' => 'Compte'))
            ->add('status', null, array('Statut'))
            ->add('instances', null, array('associated_property' => 'name'));
    }
}
