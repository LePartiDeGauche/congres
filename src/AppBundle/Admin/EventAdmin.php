<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class EventAdmin extends Admin
{
    protected $baseRouteName = 'events';
    protected $baseRoutePattern = 'events';
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
           // ->add('id')
            ->add('name', NULL, array('label' => 'Nom'))
            ->add('description', NULL, array('label' => 'Description'))
            ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('name', NULL, array('label' => 'Nom'))
            ->add('description', NULL, array('label' => 'Description'))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
            ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', NULL, array('label' => 'Nom'))
            ->add('description', NULL, array('label' => 'Description'))
            ->add('roles', 'sonata_type_collection', array(
                'type_options' => array(
                    'delete' => false
                )
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

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name', NULL, array('label' => 'Nom'))
            ->add('description', NULL, array('label' => 'Description'))
            ->add('roles', 'sonata_type_collection')
            ->add('sleepingFacilities', 'sonata_type_collection')
            ;
    }

    public function prePersist($object)
    {
        foreach ($object->getRoles() as $role) {
            $role->setEvent($object);
        }

        foreach ($object->getSleepingFacilities() as $sf) {
            $sf->setEvent($object);
        }
    }

    public function preUpdate($object)
    {
        foreach ($object->getRoles() as $role) {
            $role->setEvent($object);
        }

        foreach ($object->getSleepingFacilities() as $sf) {
            $sf->setEvent($object);
        }
    }
}
