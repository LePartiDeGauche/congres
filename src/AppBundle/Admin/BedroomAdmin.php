<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 *  Bedroom administration
 *
 * @author Clément Talleu <clement@les-tilleuls.coop>
 */
class BedroomAdmin extends Admin
{
    protected $baseRouteName = 'bedroom_admin';
    protected $baseRoutePattern = 'bedroom_admin';

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('roomType.sleepingSite', null, array('label' => 'Lieu concerné'))
            ->add('roomType', null, array('label' => 'Type de chambre'))
            ->add('number', null, array('label' => 'Numéro de la chambre'))
            ->add('dateStartAvailability', null, array('label' => 'Ouverte à partir de'))
            ->add('dateStopAvailability', null, array('label' => ' Jusque'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('roomType.sleepingSite', null, array('label' => 'Lieu concerné'))
            ->add('roomType', null, array('label' => 'Type de chambre'))
            ->add('number', null, array('label' => 'Numéro de la chambre'))
            ->add('roomType.places', null, array('label' => 'Capacité'))
            ->add('dateStartAvailability', null, array('label' => 'Ouverte à partir de'))
            ->add('dateStopAvailability', null, array('label' => ' Jusque'))
            ->add('bookings', null, array('label' => 'Réservations', 'template' => 'admin/bookings_custom_list.html.twig'))
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
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('roomType', null, array('label' => 'Type de chambre'))
            ->add('number', null, array('label' => 'Numéro de la chambre'))
            ->add('dateStartAvailability', null, array('label' => 'Ouverte à partir de'))
            ->add('dateStopAvailability', null, array('label' => ' Jusque'))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('roomType.sleepingSite', null, array('label' => 'Lieu concerné'))
            ->add('roomType', null, array('label' => 'Type de chambre'))
            ->add('number', null, array('label' => 'Numéro de la chambre'))
            ->add('roomType.places', null, array('label' => 'Capacité'))
            ->add('dateStartAvailability', null, array('label' => 'Ouverte à partir de'))
            ->add('dateStopAvailability', null, array('label' => 'Jusque'))
        ;
    }

    /**
     * @return array
     */
    public function getExportFields()
    {
        return array(
            'roomType',
            'number',
            'dateStartAvailability',
            'dateStopAvailability',
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