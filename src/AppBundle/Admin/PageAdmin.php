<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 *  Page administration
 *
 * @author Clément Talleu <clement@les-tilleuls.coop>
 */
class PageAdmin extends Admin
{
    protected $baseRouteName = 'page_admin';
    protected $baseRoutePattern = 'page_admin';

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id', null, array('label' => ''))
            ->add('category', null, array('label' => 'Catégorie'))
            ->add('title', null, array('label' => 'Titre de la page'))
            ->add('content', null, array('label' => 'Contenu'))
            ->add('isActive', null, array('label' => 'Page active'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', null, array('label' => ''))
            ->add('category', null, array('label' => 'Catégorie'))
            ->add('title', null, array('label' => 'Titre de la page'))
            ->add('content', null, array('label' => 'Contenu'))
            ->add('isActive', null, array('label' => 'Page active'))
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
            ->add('category', null, array('label' => 'Catégorie'))
            ->add('title', null, array('label' => 'Titre de la page'))
            ->add('content', null, array('label' => 'Contenu', 'attr' => ['class' => 'tinymce', 'data-theme' => 'markdown']))
            ->add('isActive', null, array('label' => 'Page active'))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id', null, array('label' => ''))
            ->add('category', null, array('label' => 'Catégorie'))
            ->add('title', null, array('label' => 'Titre de la page'))
            ->add('content', null, array('label' => 'Contenu'))
            ->add('isActive', null, array('label' => 'Page active'))
        ;
    }

    /**
     * @return array
     */
    public function getExportFields()
    {
        return array(
            'category',
            'title',
            'contenu',
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