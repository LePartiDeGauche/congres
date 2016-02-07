<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class EventAdmin extends Admin
{
    protected $baseRouteName = 'event_admin';
    protected $baseRoutePattern = 'event';
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            // ->add('id')
            ->add('name', null, array('label' => 'Nom'))
            ->add('description', null, array('label' => 'Description'))
            ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('name', null, array('label' => 'Nom'))
            ->add('normalizedName', null, array('label' => 'Nom affiché dans paybox'))
            ->add('description', null, array('label' => 'Description'))
            ->add('registrationBegin', null, array('label' => 'Début des inscriptions'))
            ->add('registrationEnd', null, array('label' => 'Fin des inscriptions'))
            ->add('nbRegistrations', null, array('label' => 'Nombre d\'inscriptions'))
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
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', null, array('label' => 'Nom'))
            ->add('normalizedName', null, array('label' => 'Nom affiché dans paybox (sans espace, sans tiret, sans caractères spéciaux)'))
            ->add('description', null, array('label' => 'Description'))
            ->add('registrationBegin', 'sonata_type_date_picker', array(
                'label' => 'Début des inscriptions',
                'format' => 'd/M/y',
            ))
            ->add('registrationEnd', 'sonata_type_date_picker', array(
                'label' => 'Fin des inscriptions',
                'format' => 'd/M/y',
            ))
            ->add('roles', 'sonata_type_collection',
                array(
                    'type_options' => array(
                        'delete' => true,
                    ),
                ), array(
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'position',
                ), array(
                    'required' => false,
                )
            )
            ->add('eventPriceScales', 'sonata_type_model', array(
                'expanded' => true,
                'multiple' => true,
            )
            // ,
            //     array(
            //         'type_options' => array(
            //             'delete' => true,
            //         ),
            //         'label' => 'Tarifs',
            //     ), array(
            //         'edit' => 'inline',
            //         'inline' => 'table',
            //         'sortable' => 'position',
            //     ), array(
            //         'required' => false,
            //     )
            )
            ->add('meals', 'sonata_type_collection',
                array(
                    'type_options' => array(
                        'delete' => true,
                    ),
                    'label' => 'Repas',
                ), array(
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'position',
                ), array(
                    'required' => false,
                )
            )
            ->add('costs', 'sonata_type_collection',
                array(
                    'type_options' => array(
                        'delete' => true,
                    ),
                    'label' => 'Tarifs',
                ), array(
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'position',
                ), array(
                    'required' => false,
                )
            )
            ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name', null, array('label' => 'Nom'))
            ->add('normalizedName', null, array('label' => 'Nom affiché dans paybox'))
            ->add('description', null, array('label' => 'Description'))
            ->add('registrationBegin', null, array('label' => 'Début des inscriptions'))
            ->add('registrationEnd', null, array('label' => 'Fin des inscriptions'))
            ->add('roles', 'sonata_type_collection')
            ->add('meals', 'sonata_type_collection', array('label' => 'Repas'))
            ->add('costs', 'sonata_type_collection', array('label' => 'Tarifs'))
            ;
    }

    public function prePersist($object)
    {
        foreach ($object->getRoles() as $role) {
            $role->setEvent($object);
        }

        foreach ($object->getEventPriceScales() as $eps) {
            $eps->addEvent($object);
        }

        foreach ($object->getMeals() as $meal) {
            $meal->setEvent($object);
        }

        foreach ($object->getCosts() as $cost) {
            $cost->setEvent($object);
        }
    }

    public function preUpdate($object)
    {
        foreach ($object->getRoles() as $role) {
            $role->setEvent($object);
        }

        foreach ($object->getEventPriceScales() as $eps) {
            $eps->addEvent($object);
        }

        foreach ($object->getMeals() as $meal) {
            $meal->setEvent($object);
        }

        foreach ($object->getCosts() as $cost) {
            $cost->setEvent($object);
        }
    }
}
