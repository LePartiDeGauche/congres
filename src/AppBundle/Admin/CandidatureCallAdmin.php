<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use AppBundle\Entity\Adherent;

class CandidatureCallAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('title')
            ->add('description')
            ->add('openingDate')
            ->add('closingDate')
            ->add('vacancyNumber')
            ->add('gender')
            ->add('faithProfessionLength')
            ->add('faithProfessionDescription')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('title')
            ->add('isVisible')
            ->add('openingDate')
            ->add('closingDate')
            ->add('vacancyNumber')
            ->add('gender')
            ->add('faithProfessionLength')
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
            ->add('title')
            ->add('description', null, array(
                'attr' => ['class' => 'tinymce', 'data-theme' => 'markdown']
            ))
            ->add('isVisible')
            ->add('openingDate', 'sonata_type_datetime_picker')
            ->add('closingDate', 'sonata_type_datetime_picker')
            ->add('vacancyNumber')
            ->add('gender', 'choice', array(
                'label' => 'Genre',
                'choices' => array_combine(Adherent::getGenderValues(), Adherent::getGenderValues()),
            ))
            ->add('responsability')
            ->add('faithProfessionLength')
            ->add('faithProfessionDescription')
            ->add('isTaskEnabled')
            ->add('taskDescription')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('title')
            ->add('description')
            ->add('openingDate')
            ->add('closingDate')
            ->add('vacancyNumber')
            ->add('gender')
            ->add('faithProfessionLength')
            ->add('faithProfessionDescription')
        ;
    }
}
