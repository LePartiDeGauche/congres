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
                'placeholder' => 'Rechercher un nom ou un email',
                'property' => array('firstname', 'lastname', 'email'),
                'to_string_callback' => function ($adherent, $property) {
                    return $adherent->getFirstname() . ' '
                        . $adherent->getLastname() . ' &lt;'
                        . $adherent->getEmail() . '&gt;';
                },
            ))
            ->add('responsability')
            ->add('professionfoi')
            ->add('isSortant')
            ->add('professionfoicplt')
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

    public function getExportFields()
    {
        return array(
            'Prenom'=>'author.firstname',
            'Nom'=>'author.lastname',
            'Genre'=>'author.gender',
            'Mail'=>'author.email',
            'Mobile'=>'author.mobilephone',
            'Comité'=>'author.organsnames',
            'Statut adhérent'=>'author.status',
            'Responsabilité'=>'responsability',
            'Profession de foi'=>'professionfoi',
            'Profession de foi cplt'=>'professionfoicplt',
            'Est Sortant'=>'isSortant',
            'Date de candidature'=>'submitDate',
            'Statut de candidature'=>'status',
            );
    }
}
