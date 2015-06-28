<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 *  Booking administration
 *
 * @author Clément Talleu <clement@les-tilleuls.coop>
 */
class BookingAdmin extends Admin
{
    protected $baseRouteName = 'booking_admin';
    protected $baseRoutePattern = 'booking_admin';

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('date', null, array('label' => 'Date'))
            ->add('bedroom', null, array('label' => 'Chambre'))
            ->add('price', null, array('label' => 'Prix'))
            ->add('bedroom.roomType.sleepingSite.event', null, array('label' => 'Événement'))
        ;
    }

    /**
     * Default Datagrid values
     *
     * @var array
     */
    protected $datagridValues = array (

        '_sort_order' => 'DESC',
    );

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('adherent', null, array('label' => 'Adhérent'))
            ->add('date', null, array('label' => 'Date'))
            ->add('bedroom', null, array('label' => 'Chambre'))
            ->add('price', null, array('label' => 'Prix'))
            ->add('bedroom.roomType.sleepingSite.event', null, array('label' => 'Événement'))
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
        // FIXME adherent lookup function should be shared with every admin object
        $formMapper
            ->add('adherent', 'sonata_type_model_autocomplete', array(
                'label' => 'Auteur',
                'property' => array('firstname', 'lastname', 'email'),
                'placeholder' => 'Rechercher un nom ou un email',
                'callback' => array($this, 'adherentCallback'),
                'to_string_callback' => array($this, 'adherentToStringCallback'), ))
            ->add('date', null, array('label' => 'Date'))
            ->add('bedroom', null, array('label' => 'Chambre'))
            ->add('price', null, array('label' => 'Prix'))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('adherent', null, array('label' => 'Adhérent'))
            ->add('date', null, array('label' => 'Date'))
            ->add('bedroom', null, array('label' => 'Chambre'))
            ->add('price', null, array('label' => 'Prix'))
        ;
    }

    /**
     * @return array
     */
    public function getExportFields()
    {
        return array(
            'adherent',
            'date',
            'bedroom',
            'bedroom.roomType.sleepingSite.event',
            'price',
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

    public function adherentCallback($admin, $property, $value)
    {
        $datagrid = $admin->getDatagrid();
        $queryBuilder = $datagrid->getQuery();
        $queryBuilder
            ->andWhere($queryBuilder->getRootAlias().'.firstname LIKE :value')
            ->orWhere($queryBuilder->getRootAlias().'.lastname LIKE :value')
            ->orWhere($queryBuilder->getRootAlias().'.email LIKE :value')
            ->setParameter('value', '%'.$value.'%')
        ;
    }

    public function adherentToStringCallback($user, $property)
    {
        $firstname = $user->getFirstname();
        $lastname = $user->getLastname();
        $email = $user->getEmail();

        return $firstname.' '.$lastname.' &lt;'.$email.'&gt;';
    }
}
