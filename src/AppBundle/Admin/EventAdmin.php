<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class EventAdmin extends Admin
{
    protected $baseRouteName = 'event_admin';
    protected $baseRoutePattern = 'event';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('clone', $this->getRouterIdParameter().'/clone');
    }

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
            ->add('isVisible')
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
                    'clone' => array(
                        'template' => 'admin/list__action_clone.html.twig'
                    )
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
            ->add('isVisible')
            ->add('normalizedName', null, array('label' => 'Nom affiché dans paybox (sans espace, sans tiret, sans caractères spéciaux)'))
            ->add('description', null, array('label' => 'Description'))
            ->add('registrationBegin', 'sonata_type_date_picker', array(
                'label' => 'Début des inscriptions',
            ))
            ->add('registrationEnd', 'sonata_type_date_picker', array(
                'label' => 'Fin des inscriptions',
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
            ->add('isRolesCommentEnabled', null, array(
                'label' => 'Activer les commentaires sur les rôles'
            ))
            ->add('rolesCommentHelpText', null, array(
                'label' => 'Message d\'aide à propos de la case "Commentaire sur le rôle"'
            ))
            ->add('priceScales', 'sonata_type_model', array(
                'label' => 'Barême des tarifs',
                'expanded' => true,
                'multiple' => true,
            ))
            ->add('sleepingTypes', 'sonata_type_model', array(
                'label' => 'Types d\'hébergement',
                'expanded' => true,
                'multiple' => true,
            ))
            ->add('isSleepingTypesCommentEnabled', null, array(
                'label' => 'Activer les précisions sur les hébergements',
            ))
            ->add('sleepingTypesCommentHelpText', null, array(
                'label' => 'Message d\'aide à propos de la case "Précision sur l\'hébergements"'
            ))
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

        foreach ($object->getPriceScales() as $priceScale) {
            $priceScale->addEvent($object);
        }

        foreach ($object->getSleepingTypes() as $sleepingType) {
            $sleepingType->addEvent($object);
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

        foreach ($object->getPriceScales() as $priceScale) {
            $priceScale->addEvent($object);
        }

        foreach ($object->getSleepingTypes() as $sleepingType) {
            $sleepingType->addEvent($object);
        }

        foreach ($object->getMeals() as $meal) {
            $meal->setEvent($object);
        }

        foreach ($object->getCosts() as $cost) {
            $cost->setEvent($object);
        }
    }
}
