<?php
namespace AppBundle\Admin;

use AppBundle\Entity\Event\Bedroom;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 *  Bedroom administration
 *
 * @author Clément Talleu <clement@les-tilleuls.coop>
 */
class BedroomAdmin extends Admin
{
    protected $baseRouteName = 'bedroom_admin';
    protected $baseRoutePattern = 'bedroom_admin';

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('roomType', null, array('label' => 'Type de chambre'))
            ->add('number', null, array('label' => 'Numéro de la chambre'))
            ->add('codeOrKey', null, array('label' => 'Code ou clé'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('roomType', null, array('label' => 'Type de chambre'))
            ->add('number', null, array('label' => 'Numéro de la chambre'))
            ->add('codeOrKey', null, array('label' => 'Code ou clé'))
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
            ->add('roomType', null, array('label' => 'Type de chambre'))
            ->add('number', null, array('label' => 'Numéro de la chambre'))
            ->add('codeOrKey', null, array('label' => 'Code ou clé'))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('roomType', null, array('label' => 'Type de chambre'))
            ->add('number', null, array('label' => 'Numéro de la chambre'))
            ->add('codeOrKey', null, array('label' => 'Code ou clé'))        ;
    }

    /**
     * @return array
     */
    public function getExportFields()
    {
        return array(
            'roomType',
            'number',
            'codeOrKey',
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
