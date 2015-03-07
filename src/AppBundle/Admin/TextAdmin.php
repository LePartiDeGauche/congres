<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use AppBundle\Entity\Text\Text;

class TextAdmin extends Admin
{
    protected $baseRouteName = 'text_admin';
    protected $baseRoutePattern = 'text_admin';
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('textGroup')
            ->add('author.lastname', null, array('label' => 'Nom de l\'auteur'))
            ->add('author.firstname', null, array('label' => 'Prénom de l\'auteur'))
            ->add('title')
            ->add('content')
            ->add('status', null, array(
                'label' => 'Statut'),
                'choice', array( 'choices' => array(
                    Text::STATUS_NEW => 'Nouveau',
                    Text::STATUS_PROPOSED => 'Proposés (Visible)',
                    Text::STATUS_VOTING => 'Soumis au vote',
                    Text::STATUS_ADOPTED => 'Adopté / Validé',
                    Text::STATUS_REJECTED => 'Rejeté',
                ),
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
            ->add('id')
            ->add('textGroup', 'sonata_type_model',
                array('multiple' => false,
                'required' => true
            ))
            ->add('title')
            ->add('content')
            ->add('status', 'choice', array(
                'label' => 'Statut',
                'choices' => array(
                    Text::STATUS_NEW => 'Nouveau',
                    Text::STATUS_PROPOSED => 'Proposés (Visible)',
                    Text::STATUS_VOTING => 'Soumis au vote',
                    Text::STATUS_ADOPTED => 'Adopté / Validé',
                    Text::STATUS_REJECTED => 'Rejeté',
                ),
                'multiple' => false,
            ))
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
            ->add('textGroup', 'sonata_type_model',
                array('multiple' => false,
                'required' => true,
                'btn_add' => false,
            ))
            ->add('author', 'sonata_type_model_autocomplete', array(
                'label' => 'Auteur',
                'property' => array('firstname', 'lastname', 'email'),
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
                    $firstname = $user->getFirstname();
                    $lastname = $user->getLastname();
                    $email = $user->getEmail();
                    return $firstname . ' ' . $lastname . ' &lt;' . $email . '&gt;';
                },
            ))
            ->add('title')
            ->add('content')
            ->add('status', 'choice', array(
                'label' => 'Statut',
                'choices' => array(
                    Text::STATUS_NEW => 'Nouveau',
                    Text::STATUS_PROPOSED => 'Proposés (Visible)',
                    Text::STATUS_VOTING => 'Soumis au vote',
                    Text::STATUS_ADOPTED => 'Adopté / Validé',
                    Text::STATUS_REJECTED => 'Rejeté',
                ),
                'multiple' => false,
            ))
            ;
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('textGroup')
            ->add('title')
            ->add('content')
            ->add('status', 'choice', array(
                'label' => 'Statut',
                'choices' => array(
                    Text::STATUS_NEW => 'Nouveau',
                    Text::STATUS_PROPOSED => 'Proposés (Visible)',
                    Text::STATUS_VOTING => 'Soumis au vote',
                    Text::STATUS_ADOPTED => 'Adopté / Validé',
                    Text::STATUS_REJECTED => 'Rejeté',
                ),
                'multiple' => false,
            ))
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
}
