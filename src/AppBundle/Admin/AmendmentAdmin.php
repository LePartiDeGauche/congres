<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Text\Amendment;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Amendment administration.
 *
 * @author Kévin Dunglas <kevin@les-tilleuls.coop>
 */
class AmendmentAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('text', null, array('label' => 'Texte'))
            ->add('author', null, array('label' => 'Auteur'))
            ->add('startLine', null, array('label' => 'Ligne'))
            ->add('type', 'choice', array('label' => 'Type de modification', 'choices' => Amendment::getTypes()))
            ->add('content', null, array('label' => 'Contenu'))
            ->add('meetingDate', 'sonata_type_date_picker', array(
                'format' => 'd/M/y',
                'label' => 'Date de réunion',
            ))
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
            ->add('text', null, array('label' => 'Texte'))
            ->add('author', null, array('label' => 'Auteur'))
            ->add('startLine', null, array('label' => 'Ligne'))
            ->add('type', null, array('label' => 'Type de modification'))
            ->add('content', null, array('label' => 'Contenu'))
            ->add('meetingDate', null, array('label' => 'Date de réunion'))
            ->add('numberOfPresent', null, array('label' => 'Nombre de présents'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('id')
            ->add('text', null, array('label' => 'Texte'))
            ->add('author.profile.lastname', null, array('label' => 'Nom'))
            ->add('author.profile.firstname', null, array('label' => 'Prénom'))
            ->add('author.profile.organs', 'sonata_type_collection', array('associated_property' => 'organ', 'label' => 'Instance'))
            ->add('startLine', null, array('label' => 'Ligne'))
            ->add('humanReadableType', null, array('label' => 'Type de modification'))
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
            ->add('text', null, array('label' => 'Texte'))
            ->add('author.profile.lastname', null, array('label' => 'Nom auteur'))
            ->add('startLine', null, array('label' => 'Ligne'))
            ->add('type', null, array('label' => 'Type de modification'), 'choice', array('choices' => Amendment::getTypes()))
            ->add('content', null, array('label' => 'Contenu'))
            ->add('meetingDate', null, array('label' => 'Date de réunion'))
        ;
    }

    /**
     * @return array
     */
    public function getExportFields()
    {
        return array(
            'text',
            'author.profile.lastname',
            'author.profile.firstname',
            'author.profile.organsnames',
            'startLine',
            'humanReadableType',
            'content',
            'meetingDate',
            'numberOfPresent',
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
