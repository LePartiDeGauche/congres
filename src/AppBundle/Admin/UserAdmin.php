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
    protected $roleChoice = array (
        'ROLE_ADMIN' => 'Administrateur',
        'ROLE_SUPER_ADMIN' => 'Super administrateur',
        'ROLE_STAFF' => 'Gestionnaire des inscriptions',
        'ROLE_VOTE_COMITY' => 'Commission des votes',
    );

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
    }

    protected function configureFormFields(FormMapper $formMapper)
    {

        $formMapper
            ->add('enabled', 'checkbox', array('label' => 'Compte Activé', 'required' => false))
            ->add('locked', 'checkbox', array('label' => 'Compte Bloqué', 'required' => false))
            ->add('roles', 'choice', array(
                'choices' => $this->roleChoice,
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
            ->add('enabled', null, array('label' => 'Compte Actif'))
            ->add('profile.firstname', null, array('label' => 'Prénom'))
            ->add('profile.lastname', null, array('label' => 'Nom'));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('email')
            ->add('enabled')
            ->add('roles', 'array');
    }
}
