<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class AdherentResponsabilityAdmin extends Admin
{
    protected $baseRouteName = 'adherent_responsability_admin';
    protected $baseRoutePattern = 'adherent/responsability';
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('responsability.name')
            ->add('start')
            ->add('end')
            ->add('isActive')
            ->add('designatedByOrgan')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('responsability')
            ->add('start')
            ->add('end')
            ->add('isActive')
            ->add('designatedByOrgan')
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
            ->add('responsability', 'sonata_type_model')
            ->add('start')
            ->add('end')
            ->add('isActive', null, array('required' => null))
            ->add('designatedByOrgan', 'sonata_type_model_autocomplete', array('property' => array('name'), 'required' => false))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('responsability')
            ->add('start')
            ->add('end')
            ->add('isActive')
        ;
    }
}
