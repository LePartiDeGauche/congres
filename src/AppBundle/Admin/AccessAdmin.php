<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBUndle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

final class AccessAdmin extends Admin
{
    protected $baseRouteName = 'acces';
    protected $baseRoutePattern = 'acces';

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('route', null, array('label' => 'Chemin d\'acces'))
            ->add('begin', null, array('label' => 'Date de début'))
            ->add('end', null, array('label' => 'Date de fin'))
            ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('route', null, array('label' => 'Chemin d\'acces'))
            ->add('begin', null, array('label' => 'Date de début'))
            ->add('end', null, array('label' => 'Date de fin'));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('route', null, array('label' => 'Chemin d\'acces'))
            ->add('begin', null, array('label' => 'Date de début'))
            ->add('end', null, array('label' => 'Date de fin'));
    }
}
