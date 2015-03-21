<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use AppBundle\Entity\Vote\IndividualTextVoteAgregation;


use AppBundle\Entity\Vote\ThresholdVoteRule;

class VoteRuleAdmin extends Admin
{
    protected $baseRouteName = 'vote_rule';
    protected $baseRoutePattern = 'vote_rule';
    protected $needsFlush = false;
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('name')
            ->add('concernedResponsability')
            ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $subject = $this->getSubject();

        $listMapper
            ->add('id')
            ->add('name')
            ->add('concernedResponsability', 'sonata_type_model', array('multiple' => true,
                'required' => false,
            ))
            ;

        if ($subject instanceof ThresholdVoteRule)
        {
            $listMapper
                ->add('threshold')
                ;
        }
        $listMapper->add('_action', 'actions', array(
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
        $subject = $this->getSubject();
        $formMapper
            ->add('name')
            ->add('textGroup')
            ->add('concernedResponsability', 'sonata_type_model', array('multiple' => true,
                'required' => false,
            ))
            ;

        if ($subject instanceof ThresholdVoteRule)
        {
            $formMapper
                ->add('threshold')
                ;
        }
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $subject = $this->getSubject();

        $showMapper
            ->add('id')
            ->add('name')
            ->add('concernedResponsability');

        if ($subject instanceof ThresholdVoteRule)
        {
            $showMapper
                ->add('threshold')
                ;
        }
    }
    public function postPersist($voteRule) {

        $textGroup = $voteRule->getTextGroup();
        $em = $this->getModelManager()->getEntityManager($this->getClass());

        // FIXME add existing user votes to agregator!
        foreach ( $textGroup->getTexts() as $text)
        {
            $itva = new IndividualTextVoteAgregation($text, $textGroup, $voteRule);
            $text->addIndividualVoteAgregation($itva);
            $em->persist($itva);
            $em->persist($text);
        }

        $em->flush();
    }

}
