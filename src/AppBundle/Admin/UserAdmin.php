<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBUndle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

final class UserAdmin extends Admin
{
    protected $baseRouteName = 'utilisateurs';
    protected $baseRoutePattern = 'utilisateurs';

    protected function configureFormFields(FormMapper $formMapper)
    {
        $roles = array('ROLE_ADMIN' => 'Administrateur');

        $formMapper
            ->add('roles', 'choice', array(
                'choices' => $roles,
                'multiple' => true,
                'required' => false,
                'expanded' => true
            ));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('email')
            ->add('roles');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('email')
            ->add('roles', 'array');
    }
}
