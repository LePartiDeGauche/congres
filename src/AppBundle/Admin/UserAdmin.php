<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBUndle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

final class UserAdmin extends Admin
{
    protected $baseRouteName = 'utilisateurs';
    protected $baseRoutePattern = 'utilisateurs';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $roles = array('ROLE_ADMIN' => 'Administrateur');

        $formMapper
            ->add('enabled', 'checkbox', array('label' => 'Compte Actif'))
            ->add('roles', 'choice', array(
                'choices' => $roles,
                'multiple' => true,
                'required' => false,
                'expanded' => true,
            ));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('email')
            ->add('roles')
            ->add('enabled', null, array('label' => 'Compte Actif'));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('email')
            ->add('enabled')
            ->add('roles', 'array');
    }
}
