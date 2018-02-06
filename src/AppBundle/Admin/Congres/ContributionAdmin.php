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
use Sonata\AdminBundle\Show\ShowMapper;

class ContributionAdmin extends Admin
{
    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('title', null, array('label' => 'Titre'))
            ->add('author.profile', null, array('label' => 'Auteur'))
            ->add('author.profile.departement', null, array('label' => 'Département'))
            ->add('status', 'choice', array(
                'label' => 'Statut',
                'choices' => array(
                    Contribution::STATUS_SIGNATURES_CLOSED => 'Contribution validée',
                    Contribution::STATUS_REJECTED => 'Contribution rejetée',
                    Contribution::STATUS_SIGNATURES_OPEN => 'Ouverte aux signatures',
                    Contribution::STATUS_NEW => 'Envoyée mais non validée (non publique)',
                ),
            ))
            ->add('deposit_type', 'choice', array(
                'label' => 'Type de dépôt',
                'choices' => array(
                    Contribution::DEPOSIT_TYPE_INDIVIDUAL => 'Individuel',
                    Contribution::DEPOSIT_TYPE_SEN => 'SEN',
                    Contribution::DEPOSIT_TYPE_COMMISSION => 'Commission'
                )
            ))
            ->add('deposit_type_value', null, array('label' => 'Complément'))
            ->add('content', null, array(
                'label' => 'Contenu',
                'template' => 'admin/contribution_show.html.twig'
            ))
            ->add('votes', 'sonata_type_collection', array(
                'label' => 'Signataires',
                'associated_property' => 'profile.getAdherentWithDepartementAndResponsabilitiesAsString'
            ))
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', null, array('label' => 'Titre'))
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
            ->add('deposit_type', 'choice', array(
                'label' => 'Type de dépôt',
                'choices' => array(
                    Contribution::DEPOSIT_TYPE_INDIVIDUAL => 'Individuel',
                    Contribution::DEPOSIT_TYPE_SEN => 'SEN',
                    Contribution::DEPOSIT_TYPE_COMMISSION => 'Commission'
                )
            ))
            ->add('deposit_type_value', 'text', array('label' => 'Complément'))
            ->add('status', 'choice', array(
                'label' => 'Statut',
                'choices' => array(
                    Contribution::STATUS_SIGNATURES_CLOSED => 'Contribution validée',
                    Contribution::STATUS_REJECTED => 'Contribution rejetée',
                    Contribution::STATUS_SIGNATURES_OPEN => 'Ouverte aux signatures',
                    Contribution::STATUS_NEW => 'Envoyée mais non validée (non publique)',
                ),
                'multiple' => false,
            ))
            ->add('content', null, array('label' => 'Texte'))
            ->add('votes', null, array(
                'label' => 'Signataires',
            ))
            ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title', null, array('label' => 'Titre'))
            ->add('author.profile.lastname', null, array('label' => 'Nom de l\'auteur'))
            ->add('author.profile.firstname', null, array('label' => 'Prénom de l\'auteur'))
            ->add('status', null, array('label' => 'Statut'), 'choice', array(
                'choices' => array(
                    Contribution::STATUS_SIGNATURES_CLOSED => 'Contribution validée',
                    Contribution::STATUS_REJECTED => 'Contribution rejetée',
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
            ->add('author.profile', null, array('label' => 'Auteur'))
            ->add('author.profile.departement', null, array('label' => 'Département'))
            ->add('deposit_type', 'choice', array(
                'label' => 'Type de dépôt',
                'choices' => array(
                    Contribution::DEPOSIT_TYPE_INDIVIDUAL => 'Individuel',
                    Contribution::DEPOSIT_TYPE_SEN => 'SEN',
                    Contribution::DEPOSIT_TYPE_COMMISSION => 'Commission'
                )
            ))
            ->add('deposit_type_value', null, array('label' => 'Complément'))
            ->add('status', 'choice', array(
                'label' => 'Statut',
                'choices' => array(
                    Contribution::STATUS_SIGNATURES_CLOSED => 'Contribution validée',
                    Contribution::STATUS_REJECTED => 'Contribution rejetée',
                    Contribution::STATUS_SIGNATURES_OPEN => 'Ouverte aux signatures',
                    Contribution::STATUS_NEW => 'Envoyée mais non validée (non publique)',
                ),
                'editable' => true,
            ))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array()
                ),
            ))
            ;
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
                'label' => 'Modifier le statut : contribution validée.',
                'ask_confirmation' => true,
            );

            $actions['edit_status_rejected'] = array(
                'label' => 'Modifier le statut : contribution rejetée.',
                'ask_confirmation' => true,
            );
        }

        return $actions;
    }
}
