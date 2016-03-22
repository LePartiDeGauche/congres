<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBUndle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

final class AccessAdmin extends Admin
{
    protected $baseRouteName = 'acces';
    protected $baseRoutePattern = 'acces';

    private function listRoutes()
    {
        return array(
            'contribution_submit' => 'Envoie et suppression des contributions.',
            'contribution_vote' => 'Signature des contributions.',
            'contribution_read' => 'Lecture des contributions validées',
        );
    }

    public function setRouter($router)
    {
        $this->router = $router;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('route', 'choice', array(
                'label' => 'Chemin d\'acces',
                'choices' => $this->listRoutes(),
                'choices_as_values' => false,
            ))
            ->add('begin', null, array('label' => 'Date de début'))
            ->add('end', null, array('label' => 'Date de fin'));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('route', null, array('label' => 'Chemin d\'acces'))
            ->add('begin', null, array('label' => 'Date de début'))
            ->add('end', null, array('label' => 'Date de fin'));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('route', null, array('label' => 'Chemin d\'acces'))
            ->add('begin', null, array('label' => 'Date de début'))
            ->add('end', null, array('label' => 'Date de fin'));
    }
}
