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
            ->add('status', null, array('label' => 'Statut'), 'choice', array(
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
                        'template' => 'AppBundle:admin:list_action_valid.html.twig', ),
                    'reject' => array(
                        'template' => 'AppBundle:admin:list_action_reject.html.twig', ),
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
            ->add('elected', 'sonata_type_collection', array(
                'type_options' => array(
                    'delete' => true,
                ),
            ), array(
                'edit' => 'inline',
                'inline' => 'table',
                'sortable' => 'position',
                'required' => false,
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
            ->add('numberOfVoters', null, array('label' => 'Nombre de votants'))
            ->add('validVotes', null, array('label' => 'Votes exprimés'))
            ->add('blankVotes', null, array('label' => 'Votes blancs'))
            ->add('numberOfElected', null, array('label' => 'Nombre d\'élus'))
            ->add('status', null, array('label' => 'Statut de l\'élection'))
            ->add('elected', null, array('label' => 'Élus'))
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
            'id',
            'organ',
            'electedNames',
            'electedEmail',
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

    public function getBatchActions()
    {
        $actions = parent::getBatchActions();

        if (
          $this->hasRoute('edit') && $this->isGranted('EDIT') &&
          $this->hasRoute('delete') && $this->isGranted('DELETE')
        ) {
            $actions['edit_status_open'] = array(
                'label' => 'Modifier le statut : élection ouverte.',
                'ask_confirmation' => true,
            );

            $actions['edit_status_closed'] = array(
                'label' => 'Modifier le statut : élection fermée.',
                'ask_confirmation' => true,
            );

            $actions['edit_status_validated'] = array(
                'label' => 'Modifier le statut : élection validée.',
                'ask_confirmation' => true,
            );

            $actions['edit_status_rejected'] = array(
                'label' => 'Modifier le statut : élection annulée.',
                'ask_confirmation' => true,
            );
        }

        return $actions;
    }
}
