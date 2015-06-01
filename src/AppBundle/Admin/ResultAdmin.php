<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Election\Result;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Results  administration.
 *
 * @author Clément Talleu <clement@les-tilleuls.coop>
 */
class ResultAdmin extends Admin
{
    protected $baseRouteName = 'result_admin';
    protected $baseRoutePattern = 'result_admin';

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('election', null, array('label' => 'Election'))
            ->add('result', null, array('label' => 'Résultat'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('id')
            ->add('election', null, array('label' => 'Election'))
            ->add('result', null, array('label' => 'Résultat'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('election', null, array('label' => 'Election'))
            ->add('result', null, array('label' => 'Résultat'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('election', null, array('label' => 'Election'))
            ->add('result', null, array('label' => 'Résultat'))
        ;
    }

    /**
     * @return array
     */
    public function getExportFields()
    {
        return array(
            'election',
            'result',
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
