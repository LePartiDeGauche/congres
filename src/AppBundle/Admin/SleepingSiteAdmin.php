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
            ->add('description', null, array('label' => 'Description'))
            ->add('address', null, array('label' => 'Adresse'))
            ->add('numberOfPlaces', null, array('label' => 'Nombre de places'))
            ->add('positionDescription', null, array('label' => 'Position'))
            ->add('price', null, array('label' => 'Prix'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('event', null, array('label' => 'Evénement concerné'))
            ->add('name', null, array('label' => 'Nom'))
            ->add('description', null, array('label' => 'Description'))
            ->add('address', null, array('label' => 'Adresse'))
            ->add('numberOfPlaces', null, array('label' => 'Nombre de places'))
            ->add('positionDescription', null, array('label' => 'Position'))
            ->add('price', null, array('label' => 'Prix'))
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
            ->add('event', null, array('label' => 'Evénement concerné'))
            ->add('name', null, array('label' => 'Nom'))
            ->add('description', 'choice', array(
                'label' => 'Description',
                'choices' => array(
                    SleepingSite::ROOM_SINGLE => 'Chambre simple',
                    SleepingSite::ROOM_TWIN => 'Twin : 2 lits séparés',
                    SleepingSite::ROOM_DOUBLE => 'Chambre double',
                    SleepingSite::ROOM_OTHER => 'Autre',
                ),
                'multiple' => false,
            ))
            ->add('address', null, array('label' => 'Adresse'))
            ->add('numberOfPlaces', null, array('label' => 'Nombre de places'))
            ->add('positionDescription', null, array('label' => 'Position'))
            ->add('price', null, array('label' => 'Prix'))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name', null, array('label' => 'Nom'))
            ->add('description', null, array('label' => 'Description'))
            ->add('address', null, array('label' => 'Adresse'))
            ->add('numberOfPlaces', null, array('label' => 'Nombre de places'))
            ->add('positionDescription', null, array('label' => 'Position'))
            ->add('price', null, array('label' => 'Prix'))
        ;
    }

    /**
     * @return array
     */
    public function getExportFields()
    {
        return array(
            'name',
            'description',
            'address',
            'numberOfPlaces',
            'positionDescription',
            'price',
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
