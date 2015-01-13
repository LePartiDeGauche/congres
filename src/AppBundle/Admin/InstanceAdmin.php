<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Instance;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBUndle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class InstanceAdmin extends Admin
{
    protected $baseRouteName = 'instances';
    protected $baseRoutePattern = 'instances';

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', 'choice', array(
                'label' => 'Nom',
                'choices' => array(
                    Instance::INSTANCE_BN,
                    Instance::INSTANCE_SN,
                    Instance::INSTANCE_CN,
                ),
                'multiple' => false,
            ))
            ->add('electionDate', null, array('label' => 'Date de renouvellement.'));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', 'choice', array(
                'label' => 'Nom',
                'choices' => array(
                    Instance::INSTANCE_BN,
                    Instance::INSTANCE_SN,
                    Instance::INSTANCE_CN,
                ),
                'multiple' => false,
            ))
            ->add('electionDate', null, array('label' => 'Date de renouvellement.'));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', 'choice', array(
                'label' => 'Nom',
                'choices' => array(
                    Instance::INSTANCE_BN,
                    Instance::INSTANCE_SN,
                    Instance::INSTANCE_CN,
                ),
                'multiple' => false,
            ))
            ->add('electionDate', null, array('label' => 'Date de renouvellement.'));
    }
}
