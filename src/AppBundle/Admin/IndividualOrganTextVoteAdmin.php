<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class IndividualOrganTextVoteAdmin extends Admin
{
    protected $baseRouteName = 'text_vote_report_admin';
    protected $baseRoutePattern = 'text/vote/report';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
        $collection->remove('edit');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('voteTotal')
            ->add('voteAbstention')
            ->add('voteNotTakingPart')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
            ->add('author.firstname')
            ->add('author.lastname')
            ->add('organ.name')
            ->add('meetingDate', null, array( 'label' => 'Date de la réunion' ))
            ->add('voteTotal', null, array( 'label' => 'Total des présents' ))
            ->add('voteBlank', null, array( 'label' => 'Blancs' ))
            ->add('voteAbstention', null, array( 'label' => 'Abstentions' ))
            ->add('voteNotTakingPart', null, array( 'label' => 'Ne prend pas part au vote' ))
            ->add('textVoteAgregations', 'sonata_type_model')
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('id')
            ->add('meetingDate', null, array( 'label' => 'Date de la réunion' ))
            ->add('voteTotal', null, array( 'label' => 'Total des présents' ))
            ->add('voteBlank', null, array( 'label' => 'Blancs' ))
            ->add('voteAbstention', null, array( 'label' => 'Abstentions' ))
            ->add('voteNotTakingPart', null, array( 'label' => 'Ne prend pas part au vote' ))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('meetingDate', null, array( 'label' => 'Date de la réunion' ))
            ->add('voteTotal', null, array( 'label' => 'Total des présents' ))
            ->add('voteBlank', null, array( 'label' => 'Blancs' ))
            ->add('voteAbstention', null, array( 'label' => 'Abstentions' ))
            ->add('voteNotTakingPart', null, array( 'label' => 'Ne prend pas part au vote' ))
            ->add('textVoteAgregations', 'sonata_type_model')
        ;
    }
}
