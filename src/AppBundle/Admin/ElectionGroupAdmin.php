<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * ElectionGroup  administration.
 *
 * @author Clément Talleu <clement@les-tilleuls.coop>
 */
class ElectionGroupAdmin extends Admin
{
    protected $baseRouteName = 'election_group_admin';
    protected $baseRoutePattern = 'election_group_admin';

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, array('label' => 'Nom'))
            ->add('organType', null, array('label' => 'Organe Concerné'))
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
            ->add('organType', null, array('label' => 'Organe Concerné'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('name', null, array('label' => 'Nom'))
            ->add('organType', null, array('label' => 'Organe Concerné'))
            ->add('responsableResponsability', null, array('label' => "Responsable de l'élection"))
            ->add('description', null, array(
                'attr' => ['class' => 'tinymce', 'data-theme' => 'markdown']
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name', null, array('label' => 'Nom'))
            ->add('description', null, array('label' => 'Description'))
            ->add('organType', null, array('label' => 'Organe Concerné'))
            ->add('responsableResponsability', null, array('label' => "Responsable de l'élection"))
        ;
    }

    /**
     * @return array
     */
    public function getExportFields()
    {
        return array(
            'name',
            'organType',
            'responsabilities',
            'responsableResponsability',
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
