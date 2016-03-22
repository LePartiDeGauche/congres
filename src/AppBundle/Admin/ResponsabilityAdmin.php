<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Responsability;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBUndle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class ResponsabilityAdmin extends Admin
{
    protected $baseRouteName = 'responsability';
    protected $baseRoutePattern = 'responsability';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', 'doctrine_orm_choice', array(
                'label' => 'Nom',
                'doctrine_orm_choices' => array(
                    Responsability::INSTANCE_BN,
                    Responsability::INSTANCE_SN,
                    Responsability::INSTANCE_CN,
                ),
                'choices_as_values' => false,
                'multiple' => false,
            ))
            ->add('electionDate', null, array('label' => 'Date de renouvellement.'));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', 'doctrine_orm_choice', array(
                'label' => 'Nom',
                'doctrine_orm_choices' => array(
                    Responsability::INSTANCE_BN,
                    Responsability::INSTANCE_SN,
                    Responsability::INSTANCE_CN,
                ),
                'choices_as_values' => false,
                'multiple' => false,
            ))
            ->add('electionDate', null, array('label' => 'Date de renouvellement.'));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', 'doctrine_orm_choice', array(
                'label' => 'Nom',
                'doctrine_orm_choices' => array(
                    Responsability::INSTANCE_BN,
                    Responsability::INSTANCE_SN,
                    Responsability::INSTANCE_CN,
                ),
                'choices_as_values' => false,
                'multiple' => false,
            ))
            ->add('electionDate', null, array('label' => 'Date de renouvellement.'));
    }
}
