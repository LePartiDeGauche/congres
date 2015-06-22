<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 *  Booking administration
 *
 * @author Clément Talleu <clement@les-tilleuls.coop>
 */
class BookingAdmin extends Admin
{
    protected $baseRouteName = 'booking_admin';
    protected $baseRoutePattern = 'booking_admin';

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('date', null, array('label' => 'Date'))
            ->add('bedroom', null, array('label' => 'Chambre'))
            ->add('price', null, array('label' => 'Prix'))
        ;
    }

    /**
     * Default Datagrid values
     *
     * @var array
     */
    protected $datagridValues = array (

        '_sort_order' => 'DESC',
    );

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('adherent', null, array('label' => 'Adhérent'))
            ->add('date', null, array('label' => 'Date'))
            ->add('bedroom', null, array('label' => 'Chambre'))
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
            ->add('adherent', null, array('label' => 'Adhérent'))
            ->add('date', null, array('label' => 'Date'))
            ->add('bedroom', null, array('label' => 'Chambre'))
            ->add('price', null, array('label' => 'Prix'))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('adherent', null, array('label' => 'Adhérent'))
            ->add('date', null, array('label' => 'Date'))
            ->add('bedroom', null, array('label' => 'Chambre'))
            ->add('price', null, array('label' => 'Prix'))
        ;
    }

    /**
     * @return array
     */
    public function getExportFields()
    {
        return array(
            'adherent',
            'date',
            'bedroom',
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
