<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Election\ElectionGroup;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Election Group administration.
 *
 * @author Clément Talleu <clement@les-tilleuls.coop>
 */
class ElectionGroupAdmin extends Admin
{
    protected $baseRouteName = 'electiongroup_admin';
    protected $baseRoutePattern = 'electiongroup_admin';

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, array('label' => 'Nom'))
            ->add('organ', null, array('label' => 'Organe Concerné'))
            ->add('electionResponsable', null, array('label' => "Responsable de l'élection"))
            ->add('electionResponsabilities', null, array('label' => "Rôle de l'élu"))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('id')
            ->add('name', null, array('label' => 'Nom'))
            ->add('organ', null, array('label' => 'Organe'))
            ->add('electionResponsable', null, array('label' => "Responsable de l'élection"))
            ->add('electionResponsabilities', null, array('label' => "Rôle de l'élu"))
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
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('name', null, array('label' => 'Nom'))
            ->add('organ', null, array('label' => 'Organe'))
            ->add('electionResponsable', null, array('label' => "Responsable de l'élection"))
            ->add('electionResponsabilities', 'choice', array('label' => "Rôle de l'élu" ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('name', null, array('label' => 'Nom'))
            ->add('organ', null, array('label' => 'Organe'))
            ->add('electionResponsable', null, array('label' => "Responsable de l'élection"))
            ->add('electionResponsabilities', null, array('label' => "Rôle de l'élu"))
        ;
    }

    /**
     * @return array
     */
    public function getExportFields()
    {
        return array(
            'name',
            'organ',
            'electionResponsable',
            'electionResponsabilities',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getExportFormats()
    {
        return array(
            'xls',
        );
    }
}