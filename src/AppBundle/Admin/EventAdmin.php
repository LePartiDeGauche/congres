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
            ->add('id')
            ->add('name')
            ->add('description')
            ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('name')
            ->add('description')
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
            ->add('name')
            ->add('description')
            ->add('roles', 'sonata_type_collection', array(
                'type_options' => array(
                    // Prevents the "Delete" option from being displayed
                    'delete' => false,
                    'delete_options' => array(
                        // You may otherwise choose to put the field but hide it
                        'type'         => 'hidden',
                        // In that case, you need to fill in the options as well
                        'type_options' => array(
                            'mapped'   => false,
                            'required' => false,
                        )
                    )
                )
            ), array(
                'edit' => 'inline',
                'inline' => 'table',
                'sortable' => 'position',
            ), array(
                'required' => false,
                // 'by_reference' => false
            )
        );
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('name')
            ->add('description')
            ->add('roles', 'sonata_type_collection')
            ;
    }

    public function prePersist($object)
    {
        foreach ($object->getRoles() as $role) {
            $role->setEvent($object);
        }
    }

    public function preUpdate($object)
    {
        foreach ($object->getRoles() as $role) {
            $role->setEvent($object);
        }
    }
}
