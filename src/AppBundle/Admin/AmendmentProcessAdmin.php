<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class AmendmentProcessAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('name')
            ->add('begin')
            ->add('end')
            ->add('isVisible')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('name')
            ->add('isVisible')
            ->add('begin', 'date')
            ->add('end', 'date')
            ->add('textgroup')
            ->add('participationRule')
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
            ->add('description', null, array(
                'attr' => ['class' => 'tinymce', 'data-theme' => 'markdown']
            ))
            ->add('isVisible')
            ->add('begin', 'sonata_type_date_picker', array(
                'format' => 'd/M/y',
            ))
            ->add('end', 'sonata_type_date_picker', array(
                'format' => 'd/M/y',
            ))
            ->add('textGroup', 'sonata_type_model', array(
                'multiple' => false,
                'required' => true,
                'btn_add' => false,
            ))
            ->add('participationRule', 'sonata_type_model')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('name')
            ->add('isVisible')
            ->add('begin')
            ->add('end')
            ->add('textgroup')
            ->add('participationRule')
        ;
    }
}
