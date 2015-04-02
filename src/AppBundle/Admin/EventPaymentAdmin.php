<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use AppBundle\Entity\Payment\EventPayment;

class EventPaymentAdmin extends Admin
{
    protected $baseRouteName = 'event_payment_admin';
    protected $baseRoutePattern = 'event/payment';
    protected $method_choice = array(
            EventPayment::METHOD_CASH => "Paiement en liquide",
            EventPayment::METHOD_CHEQUE=> "Paiement par chèque",
            EventPayment::METHOD_CREDIT_CARD => "Carte de crédit",
        );
    protected $status_choice = array(
            EventPayment::STATUS_BANKED => "Accepté",
            EventPayment::STATUS_PENDING => "En attente de paiement",
            EventPayment::STATUS_REFUSED => "Refusé",
        );
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {

        $datagridMapper
            ->add('drawer', null, array('label' => 'Émetteur (Chèque)'))
            ->add('author', null, array('label' => 'Auteur de paiement'))
            ->add('amount', null, array('label' => 'Montant'))
            ->add('method', 'choice', array(
                'label' => 'Mode de paiement',
                'choices' => $this->method_choice,
                'multiple' => false,
            ))
            ->add('status', 'choice', array('label' => 'Status',
                'choices' => $this->status_choice,
                'multiple' => false
            ))
            ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('drawer', null, array('label' => 'Émetteur (Chèque)'))
            ->add('author', null, array('label' => 'Auteur de paiement'))
            ->add('amount', null, array('label' => 'Montant'))
            ->add('method', 'choice', array(
                'label' => 'Mode de paiement',
                'choices' => $this->method_choice,
                'multiple' => false,
            ))
            ->add('status', 'choice', array('label' => 'Status',
                'choices' => $this->status_choice,
                'multiple' => false
            ))
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
            ->add('drawer', null, array('label' => 'Émetteur (Chèque)', 'required' => false))
            ->add('amount', null, array('label' => 'Montant'))
            ->add('method', 'choice', array(
                'label' => 'Mode de paiement',
                'choices' => $this->method_choice,
                'multiple' => false,
            ))
            ->add('status', 'choice', array('label' => 'Statut',
                'choices' => $this->status_choice,
                'multiple' => false
            ))
            ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('drawer', null, array('label' => 'Émetteur (Chèque)'))
            ->add('author', null, array('label' => 'Auteur de paiement'))
            ->add('amount', null, array('label' => 'Montant'))
            ->add('method', 'choice', array(
                'label' => 'Mode de paiement',
                'choices' => $this->method_choice,
                'multiple' => false,
            ))
            ->add('status', 'choice', array('label' => 'Status',
                'choices' => $this->status_choice,
                'multiple' => false
            ))
            ->add('date')
            ->add('account')
            ;
    }
    public function getNewInstance()
    {
        $instance = parent::getNewInstance();
        $user = $this->getConfigurationPool()->getContainer()->get('security.context')->getToken()->getUser();
        //$repo = $this->getDoctrine()->getRepository('AppBundle:Adherent')->findId($user->adherent);


        if ($instance->getAuthor() == NULL)
        {
            $instance->setAuthor($user->getProfile());
        }

        return $instance;
    }
}
