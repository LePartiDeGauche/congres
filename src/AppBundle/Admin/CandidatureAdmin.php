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
            ->add('candidatureCall', null, array('label' => 'Appel à candidature'))
            ->add('id')
            ->add('author.firstname', null, array('label' => 'Prénom de l\'auteur'))
            ->add('author.lastname', null, array('label' => 'Nom de l\'auteur'))
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
            ->add('candidatureCall', null, array('label' => 'Appel à candidature'))
            ->add('submitDate', 'date', array('label' => 'Date d\'envoi'))
            ->add('isSortant', null, array('label' => 'Sortant ?'))
            ->add('task', null, array('label' => 'Tâche'))
            ->add('status', 'choice', array(
                'label' => 'Statut',
                'choices' => $this->status_choice,
                'multiple' => false,
            ))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
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
                'placeholder' => 'Rechercher un nom ou un email',
                'property' => array('firstname', 'lastname', 'email'),
                'to_string_callback' => function ($adherent, $property) {
                    return $adherent->getFirstname().' '
                        .$adherent->getLastname().' &lt;'
                        .$adherent->getEmail().'&gt;';
                },
            ))
            ->add('candidatureCall', null, array(
                'label' => 'Appel à candidature',
            ))
            ->add('responsability', null, array(
                'label' => 'Instance',
            ))
            ->add('commissionContact', null, array(
                'label' => 'Contact pour la commission',
            ))
            ->add('publicContact', null, array(
                'label' => 'Contact public',
            ))
            ->add('task', null, array(
                'label' => 'Tâche',
            ))
            ->add('professionfoi', null, array(
                'label' => 'Profession de foi',
            ))
            ->add('isSortant', null, array(
                'label' => 'Sortant ?',
            ))
            ->add('professionfoicplt', null, array(
                'label' => 'Profession de foi (complément)',
            ))
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
            ->add('commissionContact', null, array('label' => 'Contacts pour la commission'))
            ->add('publicContact', null, array('label' => 'Contact public'))
            ->add('candidatureCall', null, array('label' => 'Appel à candidature'))
            ->add('responsability', null, array('label' => 'Instance'))
            ->add('submitDate', null, array('label' => 'Date d\'envoi'))
            ->add('status', 'choice', array(
                'label' => 'Statut',
                'choices' => $this->status_choice,
                'multiple' => false,
            ))
            ->add('task', null, array('label' => 'Tâche'))
            ->add('professionfoi', null, array('label' => 'Profession de foi'))
            ->add('isSortant', null, array('label' => 'Sortant ?'))
            ->add('professionfoicplt', null, array('label' => 'Complément'))
        ;
    }

    public function getExportFields()
    {
        return array(
            'Prenom' => 'author.firstname',
            'Nom' => 'author.lastname',
            'Genre' => 'author.gender',
            'Contact pour la commission' => 'commissionContact',
            'Contact public' => 'publicContact',
            'Mail connu' => 'author.email',
            'Mobile connu' => 'author.mobilephone',
            'Département' => 'author.departement',
            'Comité(s)' => 'author.OrgansAsString',
            'Statut adhérent' => 'author.status',
            'Date de candidature' => 'submitDate',
            'Statut de candidature' => 'status',
            'Appel à candidature' => 'candidatureCall',
            'Responsabilité' => 'responsability',
            'Tâche' => 'task',
            'Profession de foi' => 'professionfoi',
            'Est Sortant' => 'isSortant',
            'Profession de foi cplt' => 'professionfoicplt',
            );
    }

    /**
     * {@inheritdoc}
     */
    public function getExportFormats()
    {
        return array(
            'xls',
        );
    }
}
