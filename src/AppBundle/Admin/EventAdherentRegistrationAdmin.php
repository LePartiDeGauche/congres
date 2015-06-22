<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Event\Event;
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
    protected $paymentModeChoice = array(
        EventAdherentRegistration::PAYMENT_MODE_ONLINE => 'En ligne',
        EventAdherentRegistration::PAYMENT_MODE_ONSITE => 'Sur place',
    );
    protected $attendanceChoice = array(
        EventAdherentRegistration::ATTENDANCE_PRESENT => 'Présent',
        EventAdherentRegistration::ATTENDANCE_ABSENT => 'Absent',
        EventAdherentRegistration::ATTENDANCE_NOT_REGISTRED => 'Ne s\'est pas encore présenté',
    );

    // Quick fix for workaround for
    // https://github.com/sonata-project/SonataAdminBundle/issues/2630
    protected $yesnoChoice = array(

        true => 'Oui',
        false => 'Non',
    );

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        // FIXME : add fields
        $datagridMapper
            ->add('adherent.firstname', null, array('label' => 'Prénom'))
            ->add('adherent.lastname', null, array('label' => 'Nom de Famille'))
            ->add('event', null, array('label' => 'Événement', 'multiple' => true))
            ->add('adherent.email', null, array('label' => 'Courriel'))
            ->add('adherent.departement', null, array('label' => 'Département'))
            ->add('adherent.responsabilities.responsability', null, array('label' => 'Responsabilité', 'multiple' => true))
            ->add('role', null, array('label' => 'Inscrit en tant que'))
            ->add('needHosting', null, array('label' => 'Hebergement'))
            ->add('voteStatus', null, array('label' => 'Droit de vote'))
            ->add('paymentMode', null,
                array('label' => 'Modalité de paiement'),
                'choice', array(
                    'choices' => $this->paymentModeChoice,
                ))
            ->add('registrationDate', null, array('label' => 'Date d\'inscription'))
            ->add('attendance', null, array('label' => 'Présence'), 'choice', array(
                'choices' => $this->attendanceChoice, ))
            ->add('meals', null, array('label' => 'Repas'))
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
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                    ),
                ))
            ->add('adherent.firstname', null, array('label' => 'Prénom'))
            ->add('adherent.lastname', null, array('label' => 'Nom'))
            //->add('adherent.email', NULL, array('label' => 'Courriel'))
            ->add('adherent.departement', null, array('label' => 'Dpt'))
            ->add('event.name', null, array('label' => 'Événement'))
            ->add('adherent.status', null, array('label' => 'Statut'))
            ->add('adherent.responsabilities', 'sonata_type_collection', array('associated_property' => 'responsability', 'label' => 'Responsabilités au sein du parti'))
            ->add('role', null, array('label' => 'Inscrit en tant que'))
            //->add('registrationDate', null, array('label' => 'Date d\'inscription'))
            ->add('payments', null, array('label' => 'Paiements'))
            ->add('paymentMode', 'choice', array(
                'label' => 'Type de Paiement',
                'multiple' => false,
                'choices' => $this->paymentModeChoice,
            ))
            ->add('needHosting', null, array('label' => 'Hebergement'))
            ->add('voteStatus', null, array('label' => 'Droit de vote'))
            ->add('attendance', 'choice', array(
                'label' => 'Présence',
                'choices' => $this->attendanceChoice,
            ))
            //->add('cost', NULL, array('label' => 'Tarif'))
            ->add('meals', null, array('label' => 'Repas', 'multiple' => true))
            ->add('bedroom', null, array('label' => 'Chambre', 'template' => 'admin/bedroom_custom_list.html.twig'))

        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $isCreate = !$this->id($this->getSubject());

        if ($isCreate) {
            $formMapper
                // FIXME Filter event !
                ->add('event', null, array('label' => 'Événement', 'property' => 'name'))
                ->add('adherent', 'sonata_type_model_autocomplete', array(
                    'label' => 'Auteur',
                    'property' => array('firstname', 'lastname', 'email'),
                    'placeholder' => 'Rechercher un nom ou un email',
                    'callback' => array($this, 'adherentCallback'),
                    'to_string_callback' => array($this, 'adherentToStringCallback'), ));
        } else {
            $formMapper
                ->add('adherent.firstname', null, array('label' => 'Prénom', 'read_only' => true))
                ->add('adherent.lastname', null, array('label' => 'Nom', 'read_only' => true))
                ->add('adherent.responsabilities', 'sonata_type_collection',
                    array(
                        'label' => 'Responsabilités au sein du parti',
                        'type_options' => array(
                            'delete' => false,
                            'btn_add' => false,
                        ),
                        'required' => false,
                        'read_only' => true,
                        'disabled' => true,
                    ), array(
                        'edit' => 'inline',
                        'inline' => 'table',
                        'sortable' => 'position',
                    ));
        }
        $formMapper
            ->add('adherent.departement', null, array('label' => 'Département d\'adhesion'))
            ->add('registrationDate', null, array('read_only' => true, 'disabled' => true))
            // FIXME: filter role of this event !
            ->add('role') //, null, array('read_only' => !$isCreate, 'disabled' => !$isCreate))
            ->add('needHosting', 'choice', array('label' => 'necessite un hebergement', 'choices' => $this->yesnoChoice))
            // FIXME: filter cost of this event !
            ->add('cost', null, array('label' => 'Tarif'))
            ->add('paymentMode', 'choice', array(
                'label' => 'Type de Paiement',
                'multiple' => false,
                'read_only' => $isCreate,
                'disabled' => $isCreate,
                'choices' => $this->paymentModeChoice,
            ))
            // FIXME: add a new payment !
            ->add('payments', 'sonata_type_collection', array(
                'label' => 'Paiements',
                'type_options' => array(
                    'delete' => false,
                ),
            ), array(
                'edit' => 'inline',
                'inline' => 'table',
                'sortable' => 'position',
            ), array(
                'required' => false,
            ))
            // FIXME: filter meal of this event !
            ->add('meals', null, array('label' => 'Repas', 'expanded' => true))
            //->add('voteStatus', 'choice', array('label' => 'Droit de vote', 'choices' => $this->yesnoChoice))
            ->add('attendance', 'choice', array(
                'label' => 'Présence',
                'choices' => $this->attendanceChoice,
            ))

            ->add('comment')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('adherent.firstname', null, array('label' => 'Prénom', 'read_only' => true))
            ->add('adherent.lastname', null, array('label' => 'Nom', 'read_only' => true))
            ->add('event.name', null, array('label' => 'Évenement'))
            ->add('adherent.departement', null, array('label' => 'Département', 'read_only' => true))
            ->add('registrationDate', null, array('read_only' => true, 'disabled' => true))
            ->add('role', null, array('read_only' => true, 'disabled' => true))
            ->add('needHosting')
            ->add('cost', null, array('label' => 'Tarif'))
            ->add('paymentMode', 'choice', array(
                'label' => 'Type de Paiement',
                'multiple' => false,
                'choices' => $this->paymentModeChoice, ))
            ->add('payments', null, array(
                'label' => 'Paiements',
                'read_only' => true,
                'disabled' => true,
            ))
            ->add('meals', null, array('label' => 'Repas', 'expanded' => true))
            ->add('comment')
        ;
    }

    /**
     * @return array
     */
    public function getExportFields()
    {
        return array(
            'adherent.firstname',
            'adherent.lastname',
            'adherent.email',
            'adherent.departement',
            'event.name',
            'adherent.responsabilities',
            'votestatus',
            'role',
            'needhosting',
            'meals',
            'attendance',
        );
    }

    public function getExportFormats()
    {
        return array(
            'xls',
        );
    }

    public function getNewInstance()
    {
        $instance = parent::getNewInstance();
        $user = $this->getConfigurationPool()->getContainer()->get('security.context')->getToken()->getUser();
        //$repo = $this->getDoctrine()->getRepository('AppBundle:Adherent')->findId($user->adherent);

        $adherent = $user->getProfile();
        if(isset($adherent))
        {
            $instance->setAdherent($adherent);
            $instance->setAuthor($adherent);
        }

        $instance->setPaymentMode(EventAdherentRegistration::PAYMENT_MODE_ONSITE);

        return $instance;
    }
    public function prePersist($object)
    {
        foreach ($object->getPayments() as $payment) {
            $payment->setAttachedRegistration($object)
                ->setAttachedEvent($object->getEvent())
                ->setAuthor($object->getAdherent())
                ->setReferenceIdentifierPrefix($object->getEvent()->getNormalizedName())
            ;
        }
    }
    public function preUpdate($object)
    {
        foreach ($object->getPayments() as $payment) {
            $payment->setAttachedRegistration($object)
                ->setAttachedEvent($object->getEvent())
                ->setAuthor($object->getAdherent())
                ->setReferenceIdentifierPrefix($object->getEvent()->getNormalizedName())
            ;
        }
    }

    public function adherentCallback($admin, $property, $value)
    {
        $datagrid = $admin->getDatagrid();
        $queryBuilder = $datagrid->getQuery();
        $queryBuilder
            ->andWhere($queryBuilder->getRootAlias().'.firstname LIKE :value')
            ->orWhere($queryBuilder->getRootAlias().'.lastname LIKE :value')
            ->orWhere($queryBuilder->getRootAlias().'.email LIKE :value')
            ->setParameter('value', '%'.$value.'%')
        ;
    }

    public function adherentToStringCallback($user, $property)
    {
        $firstname = $user->getFirstname();
        $lastname = $user->getLastname();
        $email = $user->getEmail();

        return $firstname.' '.$lastname.' &lt;'.$email.'&gt;';
    }
}