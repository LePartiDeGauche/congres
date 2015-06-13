<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use AppBundle\Entity\Election\Candidature;

class CandidatureAdmin extends Admin
{
    protected $baseRouteName = 'candidature_admin';
    protected $baseRoutePattern = 'candidature';
    protected $status_choice = array(
                    Candidature::STATUS_NEW => 'Nouveau',
                    Candidature::STATUS_ADOPTED => 'Adopté / Validé',
                    Candidature::STATUS_REJECTED => 'Rejeté',
                );
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('author.firstname', null, array('label' => 'Prénom de l\'auteur'))
            ->add('author.lastname', null, array('label' => 'Nom de l\'auteur'))
            ->add('responsability', null, array('label' => 'Instance'))
            ->add('status', null, array(
                    'label' => 'Statut',
                ),
                'choice', array(
                    'choices' => $this->status_choice,
                    'multiple' => false,
            ))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('author.firstname', null, array('label' => 'Prénom de l\'auteur'))
            ->add('author.lastname', null, array('label' => 'Nom de l\'auteur'))
            ->add('responsability', null, array('label' => 'Instance'))
            ->add('professionfoi', null, array('label' => 'Profession de foi'))
            ->add('submitDate', null, array('label' => 'Date d\'envoi'))
            ->add('status', 'choice', array(
                'label' => 'Statut',
                'choices' => $this->status_choice,
                'multiple' => false,
            ))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
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
            ->add('author', 'sonata_type_model_autocomplete', array(
                'label' => 'Auteur',
                'property' => array('firstname', 'lastname', 'email'),
                'placeholder' => 'Rechercher un nom ou un email',
                'callback' => function ($admin, $property, $value) {
                    $datagrid = $admin->getDatagrid();
                    $queryBuilder = $datagrid->getQuery();
                    $queryBuilder
                        ->andWhere($queryBuilder->getRootAlias().'.firstname LIKE :value')
                        ->orWhere($queryBuilder->getRootAlias().'.lastname LIKE :value')
                        ->orWhere($queryBuilder->getRootAlias().'.email LIKE :value')
                        ->setParameter('value', '%'.$value.'%')
                    ;
                },
                'to_string_callback' => function ($user, $property) {
                    $firstname = $user->getFirstname();
                    $lastname = $user->getLastname();
                    $email = $user->getEmail();

                    return $firstname.' '.$lastname.' &lt;'.$email.'&gt;';
                },
            ))
            ->add('responsability')
            ->add('professionfoi')
            ->add('status', 'choice', array(
                'label' => 'Statut',
                'choices' => $this->status_choice,
                'multiple' => false,
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
            ->add('author.firstname', null, array('label' => 'Prénom de l\'auteur'))
            ->add('author.lastname', null, array('label' => 'Nom de l\'auteur'))
            ->add('responsability', null, array('label' => 'Instance'))
            ->add('professionfoi', null, array('label' => 'Profession de foi'))
            ->add('submitDate', null, array('label' => 'Date d\'envoi'))
            ->add('status', 'choice', array(
                'label' => 'Statut',
                'choices' => $this->status_choice,
                'multiple' => false,
            ))
        ;
    }
}
