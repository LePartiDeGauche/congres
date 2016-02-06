<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class OrganParticipationAdmin extends Admin
{
    protected $baseRouteName = 'organ_participation_admin';
    protected $baseRoutePattern = 'adherent/organ_participation';
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('organ.name')
            ->add('start')
            ->add('end')
            ->add('isActive')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('organ.name')
            ->add('start')
            ->add('end')
            ->add('isActive')
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('isActive', null, array('required' => false))
            ->add('organ', 'sonata_type_model_autocomplete', array(
                'property' => array('name'),
                'required' => false
            ))
            ->add('start', 'sonata_type_date_picker', array(
                'label' => 'Début',
                'format' => 'd/M/y',
            ))
            ->add('end', 'sonata_type_date_picker', array(
                'label' => 'Fin',
                'format' => 'd/M/y',
            ))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('organ.name')
            ->add('start')
            ->add('end')
            ->add('isActive')
        ;
    }
}
