<?php

/*
 * Deprecated, will be removed in further version
 */

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
            ->add('author', 'sonata_type_model_autocomplete', array(
                'label' => 'Auteur',
                'property' => array('profile.firstname', 'profile.lastname', 'email'),
                'placeholder' => 'Rechercher un nom ou un email',
                'callback' => function ($admin, $property, $value) {
                    $datagrid = $admin->getDatagrid();
                    $queryBuilder = $datagrid->getQuery();
                    $queryBuilder
                        ->leftJoin($queryBuilder->getRootAlias().'. profile', 'profile')
                        ->andWhere('profile.firstname LIKE :value')
                        ->orWhere('profile.lastname LIKE :value')
                        ->orWhere($queryBuilder->getRootAlias().'.email LIKE :value')
                        ->setParameter('value', '%'.$value.'%')
                    ;
                },
                'to_string_callback' => function ($user, $property) {
                    $firstname = $user->getProfile()->getFirstname();
                    $lastname = $user->getProfile()->getLastname();
                    $email = $user->getEmail();

                    return $firstname.' '.$lastname.' &lt;'.$email.'&gt;';
                },
            ))
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
            ->add('deposit_type', null, array('label' => 'Type de dépôt'))
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
                'ask_confirmation' => true,
            );

            $actions['edit_status_open'] = array(
                'label' => 'Modifier le statut : ouverte aux signatures.',
                'ask_confirmation' => true,
            );

            $actions['edit_status_closed'] = array(
                'label' => 'Modifier le statut : signatures récoltées.',
                'ask_confirmation' => true,
            );
        }

        return $actions;
    }
}
