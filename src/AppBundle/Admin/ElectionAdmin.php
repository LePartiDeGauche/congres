<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Election\Election;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Election  administration.
 *
 * @author Clément Talleu <clement@les-tilleuls.coop>
 */
class ElectionAdmin extends Admin
{
    protected $baseRouteName = 'election_admin';
    protected $baseRoutePattern = 'election_admin';

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('group', null, array('label' => 'Type d\'élection'))
            ->add('organ', null, array('label' => 'Lieu concerné'))
            ->add('status', null, array(
                'label' => 'Statut',
                'choices' => array(
                    Election::STATUS_OPEN => 'Election Ouverte.',
                    Election::STATUS_CLOSED => 'Election fermée.',
                    Election::ISVALID_TRUE => 'Election Validée',
                    Election::ISVALID_FALSE => 'Election Rejetée',
                ),
                'multiple' => false,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('id')
            ->add('group', null, array('label' => 'Type d\'élection'))
            ->add('organ', null, array('label' => 'Lieu concerné'))
            ->add('status', null, array('label' => 'Status'))
            ->add('elected', null, array('label' => 'Elus'))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                    'valid' => array(
                        'template' => 'AppBundle:admin:list_action_valid.html.twig'),
                    'reject' => array(
                        'template' => 'AppBundle:admin:list_action_reject.html.twig'),
                )
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('group', null, array('label' => 'Type d\'élection'))
            ->add('organ', null, array('label' => 'Lieu concerné'))
            ->add('numberOfElected', null, array('label' => 'Nombre d\'élus'))
            ->add('status', 'choice', array(
                'label' => 'Statut',
                'choices' => array(
                    Election::STATUS_OPEN => 'Election Ouverte.',
                    Election::STATUS_CLOSED => 'Election fermee.',
                    Election::ISVALID_TRUE => 'Election Validée',
                    Election::ISVALID_FALSE => 'Election Rejetée',
                ),
                'multiple' => false,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('group', null, array('label' => "Type d'élection"))
            ->add('organ', null, array('label' => 'Lieu concerné'))
            ->add('numberOfElected', null, array('label' => 'Nombre d\'élus'))
            ->add('status', null, array('label' => 'Statut de l\'élection'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('valid');
        $collection->add('reject');
    }

    /**
     * @return array
     */
    public function getExportFields()
    {
        return array(
            'electedNames',
            'electedEmail',
            'organ',
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
