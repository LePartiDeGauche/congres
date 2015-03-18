<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use AppBundle\Entity\Event\EventAdherentRegistration;

class EventAdherentRegistrationAdmin extends Admin
{
    protected $baseRouteName = 'event_registration_admin';
    protected $baseRoutePattern = 'event/registration';
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('needHosting')
            ->add('paymentMode')
            ->add('registrationDate')
            ->add('comment')
            ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('adherent.firstname', NULL, array('label' => 'Prénom'))
            ->add('adherent.lastname', NULL, array('label' => 'Nom'))
            ->add('needHosting', NULL, array('label' => 'Hebergement'))
            ->add('registrationDate')
            ->add('cost', NULL, array('label' => 'Tarif'))
            ->add('paymentMode', 'choice', array(
                'label' => 'Type de Paiement',
                'multiple' => false,
                'choices' => array(
                    EventAdherentRegistration::PAYMENT_MODE_ONLINE => 'En ligne',
                    EventAdherentRegistration::PAYMENT_MODE_ONSITE => 'Sur place',
                )
            ))
            ->add('payments', null, array(
                'label' => 'Paiements',
            ))
            ->add('meals', null, array('label' => 'Repas'))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
            ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('adherent.firstname', NULL, array('label' => 'Prénom', 'read_only' => true,))
            ->add('adherent.lastname', NULL, array('label' => 'Nom', 'read_only' => true,))
            ->add('registrationDate',null, array('read_only' => true,'disabled'  => true,))
            // FIXME: filter role of this event !
            ->add('role', null, array('read_only' =>true, 'disabled' => true))
            ->add('needHosting')
            ->add('cost', NULL, array('label' => 'Tarif'))
            ->add('paymentMode', 'choice', array(
                'label' => 'Type de Paiement',
                'multiple' => false,
                'choices' => array(
                    EventAdherentRegistration::PAYMENT_MODE_ONLINE => 'En ligne',
                    EventAdherentRegistration::PAYMENT_MODE_ONSITE => 'Sur place',
                )
            ))
            ->add('payments', null, array(
                'label' => 'Paiements',
                'read_only' => true,
                'disabled'  => true,
            ))
            // FIXME: filter meal of this event !
            ->add('meals', null, array('label' => 'Repas', 'expanded' => true))

            ->add('comment')
            ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('adherent.firstname', NULL, array('label' => 'Prénom', 'read_only' => true,))
            ->add('adherent.lastname', NULL, array('label' => 'Nom', 'read_only' => true,))
            ->add('registrationDate',null, array('read_only' => true,'disabled'  => true,))
            ->add('role', null, array('read_only' =>true, 'disabled' => true))
            ->add('needHosting')
            ->add('cost', NULL, array('label' => 'Tarif'))
            ->add('paymentMode', 'choice', array(
                'label' => 'Type de Paiement',
                'multiple' => false,
                'choices' => array(
                    EventAdherentRegistration::PAYMENT_MODE_ONLINE => 'En ligne',
                    EventAdherentRegistration::PAYMENT_MODE_ONSITE => 'Sur place',
                )
            ))
            ->add('payments', null, array(
                'label' => 'Paiements',
                'read_only' => true,
                'disabled'  => true,
            ))
            ->add('meals', null, array('label' => 'Repas', 'expanded' => true))
            ->add('comment')
            ;
    }
}
