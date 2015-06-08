<?php
namespace AppBundle\Admin;

use AppBundle\Entity\Event\RoomType;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 *  RoomType administration
 *
 * @author Clément Talleu <clement@les-tilleuls.coop>
 */
class RoomTypeAdmin extends Admin
{
    protected $baseRouteName = 'room_type';
    protected $baseRoutePattern = 'room_type';


    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('sleepingSite', null, array('label' => 'Lieu concerné'))
            ->add('name', null, array('label' => 'Nom'))
            ->add('type', 'choice', array(
                'label' => 'Type de chambre',
                'choices' => array(
                    RoomType::ROOM_SINGLE => 'Chambre simple',
                    RoomType::ROOM_TWIN => 'Twin : 2 lits séparés',
                    RoomType::ROOM_DOUBLE => 'Chambre double',
                    RoomType::ROOM_OTHER => 'Autre',
                ),
                'multiple' => false,
            ))
            ->add('description', null, array('label' => 'Description'))
            ->add('places', null, array('label' => 'Places Disponibles'))
            ->add('available', null, array('label' => 'available'))
            ->add('price', null, array('label' => 'prix'))
            ->add('canBookMore', null, array('label' => 'Possibilité de réserver plus de chambre que disponibles'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('sleepingSite', null, array('label' => 'Lieu concerné'))
            ->add('name', null, array('label' => 'Nom'))
            ->add('type', 'choice', array(
                'label' => 'Type de chambre',
                'choices' => array(
                    RoomType::ROOM_SINGLE => 'Chambre simple',
                    RoomType::ROOM_TWIN => 'Twin : 2 lits séparés',
                    RoomType::ROOM_DOUBLE => 'Chambre double',
                    RoomType::ROOM_OTHER => 'Autre',
                ),
                'multiple' => false,
            ))
            ->add('description', null, array('label' => 'Description'))
            ->add('places', null, array('label' => 'Places Disponibles'))
            ->add('available', null, array('label' => 'available'))
            ->add('price', null, array('label' => 'prix'))
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
            ->add('sleepingSite', null, array('label' => 'Lieu concerné'))
            ->add('name', null, array('label' => 'Nom'))
            ->add('type', 'choice', array(
                'label' => 'Type de chambre',
                'choices' => array(
                    RoomType::ROOM_SINGLE => 'Chambre simple',
                    RoomType::ROOM_TWIN => 'Twin : 2 lits séparés',
                    RoomType::ROOM_DOUBLE => 'Chambre double',
                    RoomType::ROOM_OTHER => 'Autre',
                ),
                'multiple' => false,
            ))
            ->add('description', null, array('label' => 'Description'))
            ->add('places', null, array('label' => 'Places Disponibles'))
            ->add('available', null, array('label' => 'available'))
            ->add('price', null, array('label' => 'prix'))
            ->add('canBookMore', null, array('label' => 'Possibilité de réserver plus de chambre que disponibles'))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('sleepingSite', null, array('label' => 'Lieu concerné'))
            ->add('name', null, array('label' => 'Nom'))
            ->add('type', 'choice', array(
                'label' => 'Type de chambre',
                'choices' => array(
                    RoomType::ROOM_SINGLE => 'Chambre simple',
                    RoomType::ROOM_TWIN => 'Twin : 2 lits séparés',
                    RoomType::ROOM_DOUBLE => 'Chambre double',
                    RoomType::ROOM_OTHER => 'Autre',
                ),
                'multiple' => false,
            ))
            ->add('description', null, array('label' => 'Description'))
            ->add('places', null, array('label' => 'Places Disponibles'))
            ->add('available', null, array('label' => 'available'))
            ->add('price', null, array('label' => 'prix'))
            ->add('canBookMore', null, array('label' => 'Possibilité de réserver plus de chambre que disponibles'))
        ;
    }

    /**
     * @return array
     */
    public function getExportFields()
    {
        return array(
            'sleepingSite',
            'name',
            'type',
            'description',
            'places',
            'available',
            'price',
            'canBookmore',
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
