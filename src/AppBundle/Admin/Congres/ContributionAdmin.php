<?php

namespace AppBundle\Admin\Congres;

use AppBundle\Entity\Congres\Contribution;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBUndle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ContributionAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', null, array('label' => 'Titre'))
            ->add('content', null, array('label' => 'Texte'))
            ->add('status', 'choice', array(
                'label' => 'Statut',
                'choices' => array(
                    Contribution::STATUS_SIGNATURES_CLOSED => 'Signatures récoltés',
                    Contribution::STATUS_SIGNATURES_OPEN => 'Ouverte aux signatures',
                    Contribution::STATUS_NEW => 'Envoyée mais non validée (non publique)',
                ),
                'multiple' => false,
            ));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title', null, array('label' => 'Titre'))
            ->add('author.profile.lastname', null, array('label' => 'Nom de l\'auteur'))
            ->add('author.profile.firstname', null, array('label' => 'Prénom de l\'auteur'))
            ->add('status', null, array('label' => 'Statut'), 'choice', array(
                'choices' => array(
                    Contribution::STATUS_SIGNATURES_CLOSED => 'Signatures récoltés',
                    Contribution::STATUS_SIGNATURES_OPEN => 'Ouverte aux signatures',
                    Contribution::STATUS_NEW => 'Envoyée mais non validée (non publique)',
                ),
                'multiple' => false,
            ));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title', null, array('label' => 'Titre'))
            ->add('author.profile', null, array('label' => 'Nom', 'associated_property' => 'lastname'))
            ->add('author.profile.firstname', null, array('label' => 'Prénom'))
            ->add('status', 'choice', array(
                'label' => 'Statut',
                'choices' => array(
                    Contribution::STATUS_SIGNATURES_CLOSED => 'Signatures récoltés',
                    Contribution::STATUS_SIGNATURES_OPEN => 'Ouverte aux signatures',
                    Contribution::STATUS_NEW => 'Envoyée mais non validée (non publique)',
                ),
                'editable' => true,
            ));
    }

    public function getBatchActions()
    {
        $actions = parent::getBatchActions();

        if (
          $this->hasRoute('edit') && $this->isGranted('EDIT') &&
          $this->hasRoute('delete') && $this->isGranted('DELETE')
        ) {
            $actions['edit_status_new'] = array(
                'label' => 'Modifier le statut : envoyée mais non validée.',
                'ask_confirmation' => true
            );

            $actions['edit_status_open'] = array(
                'label' => 'Modifier le statut : ouverte aux signatures.',
                'ask_confirmation' => true
            );

            $actions['edit_status_closed'] = array(
                'label' => 'Modifier le statut : signatures récoltées.',
                'ask_confirmation' => true
            );
        }

        return $actions;
}
}
