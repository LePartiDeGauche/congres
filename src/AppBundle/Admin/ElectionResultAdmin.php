<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ElectionResultAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('election')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('election', null, array('label' => 'Élection'))
            ->add('elected', null, array('label' => 'Élu-e-s'))
            ->add('numberOfVote', null, array('label' => 'Nombre de votes'))
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
            ->add('id')
            ->add('election', null, array('label' => 'Élection'))
            ->add('elected', null, array('label' => 'Élu-e-s'))
            ->add('numberOfVote', null, array('label' => 'Nombre de votes'))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('election', null, array('label' => 'Élection'))
            ->add('elected', null, array('label' => 'Élu-e-s'))
            ->add('numberOfVote', null, array('label' => 'Nombre de votes'))
        ;
    }

    /**
     * @return array
     */
    public function getExportFields()
    {
        return array(
            'id',
            'elected',
            'numberOfVote',
            'election',
            'election.group',
            'election.organ',
            'election.responsable',
            'election.status',
            'election.date',
            'election.numberOfElected',
            'election.numberOfVoters',
            'election.validVotes',
            'election.blankVotes',
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
