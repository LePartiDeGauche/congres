<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use AppBundle\Entity\Text\TextGroup;

class TextGroupAdmin extends Admin
{
    protected $baseRouteName = 'textgroup_admin';
    protected $baseRoutePattern = 'textgroup_admin';
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            //->add('id')
            ->add('name')
            ->add('description')
            ->add('submissionOpening')
            ->add('submissionClosing')
            ->add('voteOpening')
            ->add('voteClosing')
            ->add('voteType')
            ->add('voteModality')
            ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('author', 'sonata_type_model_autocomplete', array('property'=>'lastname'))
            ->add('name')
            ->add('description')
            ->add('submissionOpening')
            ->add('submissionClosing')
            ->add('voteOpening')
            ->add('voteClosing')
            ->add('voteType', 'choice', array(
                'label' => 'Type de vote',
                'choices' => array(
                    TextGroup::VOTETYPE_COLLECTIVE => "Vote collectif rapporté par procès verbal",
                    TextGroup::VOTETYPE_INDIVIDUAL => "Vote individuel directement sur le site",
                ),
                'multiple' => false,
            ))
            ->add('voteModality', 'choice', array(
                'label' => 'Mode de scrutin',
                'choices' => array(
                    TextGroup::VOTEMODALITY_VALIDATION => "Vote de selection des meilleurs textes",
                    TextGroup::VOTEMODALITY_REFERENDUM => "Vote referendaire",
                ),
                'multiple' => false,
            ))
            ->add('voteRules', 'sonata_type_collection')
            ->add('organVoteRules', 'sonata_type_collection')
            ->add('maxVotesByAdherent')
            ->add('isVisible')
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
            //->add('id')
            ->add('author', 'sonata_type_model_autocomplete', array('property'=>array('firstname', 'lastname')))
            ->add('name')
            ->add('description')
            ->add('submissionOpening')
            ->add('submissionClosing')
            ->add('voteOpening')
            ->add('voteClosing')
            ->add('voteType', 'choice', array(
                'label' => 'Type de vote',
                'choices' => array(
                    TextGroup::VOTETYPE_COLLECTIVE => "Vote collectif rapporté par procès verbal",
                    TextGroup::VOTETYPE_INDIVIDUAL => "Vote individuel directement sur le site",
                ),
                'multiple' => false,
            ))
            ->add('voteModality', 'choice', array(
                'label' => 'Mode de scrutin',
                'choices' => array(
                    TextGroup::VOTEMODALITY_VALIDATION => "Vote de selection des meilleurs textes",
                    TextGroup::VOTEMODALITY_REFERENDUM => "Vote referendaire",
                ),
                'multiple' => false,
            ))
            //->add('voteRules', 'sonata_type_collection',
            //    array(
            //        'type_options' => array(
            //            'delete' => false
            //        ),
            //        'label' => 'Règles de vote individuelles',
            //    ), array(
            //        'edit' => 'inline',
            //        'inline' => 'table',
            //        'sortable' => 'position',
            //    ), array(
            //        'required' => false,
            //    ))
            ->add('organVoteRules', 'sonata_type_collection',
                array(
                    'type_options' => array(
                        'delete' => false
                    ),
                    'label' => 'Règles de vote par organes',
                ), array(
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'position',
                ), array(
                    'required' => false,
                ))
            ->add('maxVotesByAdherent')
            ->add('isVisible')
            // FIXME : currently impossible to use subclass into subform with sonata bundle
            
            //->add('voteRules', 'sonata_type_collection', array(
            //    'type_options' => array(
            //        'delete' => false,
            //    )), array(
            //        'edit' => 'inline',
            //        'inline' => 'table',
            //        'sortable' => 'position',
            //    ), array(
            //        'required' => false,
            //    )
            //)
            ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('name')
            ->add('author', 'sonata_type_model_autocomplete', array(
                'label' => 'Auteur',
                'property' => array('profile.firstname', 'profile.lastname', 'email'),
                'placeholder' => 'Rechercher un nom ou un email',
                'callback' => function ($admin, $property, $value) {
                    $datagrid = $admin->getDatagrid();
                    $queryBuilder = $datagrid->getQuery();
                    $queryBuilder
                        ->andWhere($queryBuilder->getRootAlias() . '.firstname LIKE :value')
                        ->orWhere($queryBuilder->getRootAlias() . '.lastname LIKE :value')
                        ->orWhere($queryBuilder->getRootAlias() . '.email LIKE :value')
                        ->setParameter('value', '%' . $value . '%')
                    ;
                },
                'to_string_callback' => function($user, $property) {
                    $firstname = $user->getProfile()->getFirstname();
                    $lastname = $user->getProfile()->getLastname();
                    $email = $user->getEmail();

                    return $firstname . ' ' . $lastname . ' &lt;' . $email . '&gt;';
                },
            ))
            ->add('description')
            ->add('submissionOpening')
            ->add('submissionClosing')
            ->add('voteOpening')
            ->add('voteClosing')
            ->add('voteType', 'choice', array(
                'label' => 'Type de vote',
                'choices' => array(
                    TextGroup::VOTETYPE_COLLECTIVE => "Vote collectif rapporté par procès verbal",
                    TextGroup::VOTETYPE_INDIVIDUAL => "Vote individuel directement sur le site",
                ),
                'multiple' => false,
            ))
            ->add('voteModality', 'choice', array(
                'label' => 'Mode de scrutin',
                'choices' => array(
                    TextGroup::VOTEMODALITY_VALIDATION => "Vote de selection des meilleurs textes",
                    TextGroup::VOTEMODALITY_REFERENDUM => "Vote referendaire",
                ),
                'multiple' => false,
            ))
            ->add('voteRules', 'sonata_type_collection')
            ->add('maxVotesByAdherent')
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
    public function prePersist($object)
    {
        foreach ($object->getOrganVoteRules() as $ovr) {
            $ovr->setTextGroup($object);
        }
    }
    public function preUpdate($object)
    {
        foreach ($object->getOrganVoteRules() as $ovr) {
            $ovr->setTextGroup($object);
        }
    }
}

