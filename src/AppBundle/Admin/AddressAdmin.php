<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class AddressAdmin extends Admin
{
    protected $baseRouteName = 'address';
    protected $baseRoutePattern = 'address';
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('streetNumber')
            ->add('streetType')
            ->add('streetName')
            ->add('cityCode')
            ->add('cityName')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('streetNumber')
            ->add('streetType')
            ->add('streetName')
            ->add('cityCode')
            ->add('cityName')
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
            ->add('streetNumber')
            ->add('streetType')
            ->add('streetName')
            ->add('cityCode')
            ->add('cityName')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('streetNumber')
            ->add('streetType')
            ->add('streetName')
            ->add('cityCode')
            ->add('cityName')
        ;
    }
}
