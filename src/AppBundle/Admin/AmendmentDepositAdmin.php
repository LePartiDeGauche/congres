<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Text\AmendmentDeposit;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * AmendmentDeposit administration.
 *
 */
class AmendmentDepositAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $form)
    {
        $form
            // ->add('depositor', null, array('label' => 'Déposant'))
            // ->add('mandatary', null, array('label' => 'Mandataire'))
            ->add('mandataryInfo', null, array('label' => 'Fonction du mandataire'))
            ->add('origin', 'choice', array(
                'label' => 'Origine',
                'choices' => AmendmentDeposit::getOrigins())
            )
            ->add('originInfo', null, array('label' => 'Précisions'))
            ->add('meetingDate', 'sonata_type_date_picker', array(
                'format' => 'd/M/y',
                'label' => 'Date de réunion',
            ))
            ->add('meetingPlace', null, array('label' => 'Lieu de la réunion'))
            ->add('numberOfPresent', null, array('label' => 'Nombre de présents'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('depositor', null, array('label' => 'Déposant'))
            ->add('mandatary', null, array('label' => 'Mandataire'))
            ->add('mandataryInfo', null, array('label' => 'Fonction du mandataire'))
            ->add('humanReadableOrigin', null, array('label' => 'Origine'))
            ->add('originInfo', null, array('label' => 'Précisions'))
            ->add('meetingDate', null, array('label' => 'Date de réunion'))
            ->add('meetingPlace', null, array('label' => 'Lieu de la réunion'))
            ->add('numberOfPresent', null, array('label' => 'Nombre de présents'))
            ->add('items', null, array('label' => 'Amendements'))
            ->add('minutesDocumentFilename', null, array('label' => 'Procès verbal'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('id')
            ->add('depositor', null, array('label' => 'Déposant'))
            ->add('mandatary', null, array('label' => 'Mandataire'))
            ->add('humanReadableOrigin', null, array('label' => 'Origine'))
            ->add('originInfo', null, array('label' => 'Origine'))
            ->add('meetingDate', null, array('label' => 'Date de réunion'))
            ->add('numberOfPresent', null, array('label' => 'Nombre de présents'))
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
            ->add('depositor.lastname', null, array('label' => 'Nom du déposant'))
            ->add('mandatary.lastname', null, array('label' => 'Nom du mandataire'))
            ->add('origin', null, array(
                'label' => 'Type de modification'),
                'choice', array('choices' => AmendmentDeposit::getOrigins()
            ))
            ->add('meetingDate', null, array('label' => 'Date de réunion'))
        ;
    }

    /**
     * @return array
     */
    public function getExportFields()
    {
        return array(
            'Identifiant de dépôt' => 'id',
            'Déposant' => 'author',
            'Mandataire' => 'mandatary',
            'Fonctions du mandataire' => 'mandataryInfo',
            'Origine' => 'humanReadableOrigin',
            'Précision sur l\'origine' => 'originInfo',
            'Date' => 'meetingDate',
            'Lieu' => 'meetingPlace',
            'Nombre de présent' => 'numberOfPresent',
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
