<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Text\AmendmentItem;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Amendment item administration.
 *
 */
class AmendmentItemAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('text', null, array('label' => 'Texte concerné'))
            ->add('reference', null, array('label' => 'Référence'))
            ->add('type', 'choice', array(
                'label' => 'Type de modification',
                'choices' => AmendmentItem::getTypes())
            )
            ->add('startLine', null, array('label' => 'Ligne de début'))
            ->add('endLine', null, array('label' => 'Ligne de fin'))
            ->add('content', null, array('label' => 'Contenu'))
            ->add('explanation', null, array('label' => 'Motif'))
            ->add('forVote', null, array('label' => 'Votes pour'))
            ->add('againstVote', null, array('label' => 'Votes contre'))
            ->add('abstentionVote', null, array('label' => 'Abstention'))
            ->add('dtpvVote', null, array('label' => 'NPPV'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('reference')
            ->add('text', null, array('label' => 'Texte concerné'))
            ->add('humanReadableType', 'null', array('label' => 'Type de modification'))
            ->add('startLine', null, array('label' => 'Ligne de début'))
            ->add('endLine', null, array('label' => 'Ligne de fin'))
            ->add('content', null, array('label' => 'Contenu'))
            ->add('explanation', null, array('label' => 'Motif'))
            ->add('forVote', null, array('label' => 'Votes pour'))
            ->add('againstVote', null, array('label' => 'Votes contre'))
            ->add('abstentionVote', null, array('label' => 'Abstention'))
            ->add('dtpvVote', null, array('label' => 'NPPV'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('reference')
            ->add('text', null, array('label' => 'Texte concerné'))
            ->add('humanReadableType', 'null', array('label' => 'Type de modification'))
            ->add('startLine', null, array('label' => 'Ligne de début'))
            ->add('forVote', null, array('label' => 'Votes pour'))
            ->add('againstVote', null, array('label' => 'Votes contre'))
            ->add('abstentionVote', null, array('label' => 'Abstention'))
            ->add('dtpvVote', null, array('label' => 'NPPV'))
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
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('text', null, array('label' => 'Texte concerné'))
            ->add('type', null, array(
                'label' => 'Type de modification',
                'choices' => AmendmentItem::getTypes())
            )
            ->add('startLine', null, array('label' => 'Ligne de début'))
            ->add('forVote', null, array('label' => 'Votes pour'))
            ->add('againstVote', null, array('label' => 'Votes contre'))
            ->add('abstentionVote', null, array('label' => 'Abstention'))
            ->add('dtpvVote', null, array('label' => 'NPPV'))
        ;
    }

    /**
     * @return array
     */
    public function getExportFields()
    {
        return array(
            'Référence' => 'reference',
            'Déposant' => 'amendmentDeposit.depositor.getAdherentWithDepartementAndResponsabilitiesAsString',
            'Mandataire' => 'amendmentDeposit.mandatary.getAdherentWithDepartementAndResponsabilitiesAsString',
            'Fonction du mandataire' => 'amendmentDeposit.mandataryInfo',
            'Origine du dépôt' => 'amendmentDeposit.humanReadableOrigin',
            'Précisions sur l\'origine' => 'amendmentDeposit.originInfo',
            'Date de réunion' => 'amendmentDeposit.meetingDate',
            'Lieu de réunion' => 'amendmentDeposit.meetingPlace',
            'Nombre de présents' => 'amendmentDeposit.numberOfPresent',
            'Type' => 'humanReadableType',
            'Texte concerné' => 'text',
            'Ligne de début' => 'startLine',
            'Ligne de fin' => 'endLine',
            'Contenu' => 'content',
            'Motif' => 'explanation',
            'Votes pour' => 'forVote',
            'Votes contre' => 'againstVote',
            'Abstention' => 'abstentionVote',
            'NPPV' => 'dtpvVote',
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
