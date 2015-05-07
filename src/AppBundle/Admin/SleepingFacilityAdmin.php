<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class SleepingFacilityAdmin extends Admin
{
    protected $baseRouteName = 'sleeping_facilities';
    protected $baseRoutePattern = 'sleeping_facilities';
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('event')
            ->add('name')
            ->add('description')
            ->add('address')
            ->add('positionDescription')
            ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('event')
            ->add('name')
            ->add('description')
            ->add('address')
            ->add('positionDescription')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                ),
            ))
            ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('event', 'sonata_type_model')
            ->add('name')
            ->add('description')
            ->add('address', 'sonata_type_admin', array(
                'delete' => false,
                'required' => true,
                'btn_add' => false,
            ))
            ->add('positionDescription')
            ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('event')
            ->add('name')
            ->add('description')
            ->add('address')
            ->add('positionDescription')
            ;
    }
}
