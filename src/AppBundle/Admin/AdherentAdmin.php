<?php

namespace AppBundle\Admin;

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
            ->add('birthdate', null, array('label' => 'Date de naissance'));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('email')
            ->add('lastname', null, array('label' => 'Nom'))
            ->add('firstname', null, array('label' => 'Prénom'))
            ->add('birthdate', null, array('label' => 'Date de naissance'))
            ->add('user', null, array('label' => 'Compte'));
    }
}
