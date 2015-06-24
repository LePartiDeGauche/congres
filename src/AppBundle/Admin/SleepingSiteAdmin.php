<?php
namespace AppBundle\Admin;

use AppBundle\Entity\Event\SleepingSite;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Sleeping sites administration
 *
 * @author Clément Talleu <clement@les-tilleuls.coop>
 */
class SleepingSiteAdmin extends Admin
{
    protected $baseRouteName = 'sleeping_admin';
    protected $baseRoutePattern = 'sleeping_admin';

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, array('label' => 'Nom'))
            ->add('event', null, array('label' => 'Evénement'))
            ->add('description', null, array('label' => 'Description'))
            ->add('address', null, array('label' => 'Adresse'))
            ->add('latitude', null, array('label' => 'Latitude'))
            ->add('longitude', null, array('label' => 'Longitude'))
            ->add('roomTypes', null, array('label' => 'Type de chambre', 'multiple' => true))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('name', null, array('label' => 'Nom'))
            ->add('event', null, array('label' => 'Evénement'))
            ->add('description', null, array('label' => 'Description'))
            ->add('address', null, array('label' => 'Adresse'))
            ->add('latitude', null, array('label' => 'Latitude'))
            ->add('longitude', null, array('label' => 'Longitude'))
            ->add('totalCapacity', null, array('label' => 'Capacité totale'))
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
            ->add('name', null, array('label' => 'Nom'))
            ->add('event', null, array('label' => 'Evénement'))
            ->add('description', null, array('label' => 'Description'))
            ->add('address', null, array('label' => 'Adresse'))
            ->add('latitude', null, array('label' => 'Latitude'))
            ->add('longitude', null, array('label' => 'Longitude'))
            ;

        if ($this->id($this->getSubject())) {
            $formMapper
                ->add(
                    'roomTypes',
                    'sonata_type_collection',
                    array(
                        'by_reference' => false,
                    ), array(
                        'edit' => 'inline',
                        'inline' => 'table',
                        'sortable' => 'position',
                    ), array(
                        'required' => false,
                    )
                );
        }

    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name', null, array('label' => 'Nom'))
            ->add('event', null, array('label' => 'Evénement'))
            ->add('description', null, array('label' => 'Description'))
            ->add('address', null, array('label' => 'Adresse'))
            ->add('latitude', null, array('label' => 'Latitude'))
            ->add('longitude', null, array('label' => 'Longitude'))
            ->add('roomTypes', null, array('label' => 'Type de chambre', 'multiple' => true))
            ->add('totalCapacity', null, array('label' => 'Capacité totale'))
        ;
    }

    /**
     * @return array
     */
    public function getExportFields()
    {
        return array(
            'name',
            'event',
            'description',
            'address',
            'latitude',
            'longitude',
            'roomTypes',
            'bedrooms',
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
