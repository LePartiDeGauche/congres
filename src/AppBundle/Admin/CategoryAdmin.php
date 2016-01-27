<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 *  Category administration
 *
 * @author Clément Talleu <clement@les-tilleuls.coop>
 */
class CategoryAdmin extends Admin
{
    protected $baseRouteName = 'category_admin';
    protected $baseRoutePattern = 'category_admin';

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id', null, array('label' => ''))
            ->add('title', null, array('label' => 'Titre'))
            ->add('description', null, array('label' => 'Description'))
            ->add('isActive', null, array('label' => 'Menu actif'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', null, array('label' => ''))
            ->add('title', null, array('label' => 'Titre'))
            ->add('description', null, array('label' => 'Description'))
            ->add('isActive', null, array('label' => 'Menu actif'))
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
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', null, array('label' => 'Titre'))
            ->add('description', null, array('label' => 'Description'))
            ->add('isActive', null, array('label' => 'Menu actif'))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id', null, array('label' => ''))
            ->add('title', null, array('label' => 'Titre'))
            ->add('description', null, array('label' => 'Description'))
            ->add('isActive', null, array('label' => 'Menu actif'))
        ;
    }

    /**
     * @return array
     */
    public function getExportFields()
    {
        return array(
            'title',
            'description',
            'places',
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