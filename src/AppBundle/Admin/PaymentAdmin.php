<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class PaymentAdmin extends Admin
{
    protected $baseRouteName = 'payment_admin';
    protected $baseRoutePattern = 'payment';
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('amount')
            ->add('method')
            ->add('status')
            ->add('drawer')
            ->add('date')
            ->add('account')
            ->add('referenceIdentifierPrefix')
            ->add('paymentIPN')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('amount')
            ->add('method')
            ->add('status')
            ->add('drawer')
            ->add('date')
            ->add('account')
            ->add('referenceIdentifierPrefix')
            ->add('paymentIPN')
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
            ->add('id')
            ->add('amount')
            ->add('method')
            ->add('status')
            ->add('drawer')
            ->add('date')
            ->add('account')
            ->add('referenceIdentifierPrefix')
            ->add('paymentIPN')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('amount')
            ->add('method')
            ->add('status')
            ->add('drawer')
            ->add('date')
            ->add('account')
            ->add('referenceIdentifierPrefix')
            ->add('paymentIPN')
        ;
    }
}
