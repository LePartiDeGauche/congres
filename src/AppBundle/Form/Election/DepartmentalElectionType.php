<?php

namespace AppBundle\Form\Election;

use AppBundle\Entity\Adherent;
use AppBundle\Entity\AdherentRepository;
use AppBundle\Entity\Election\Election;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DepartmentalElectionType extends AbstractType
{
    private $adherent;

    public function __construct(Adherent $adherent)
    {
        $this->adherent = $adherent;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $departmentalElection = $event->getData();
            $form = $event->getForm();

            $form->add('name', null, array(
                'label' => 'Nom du rapporteur *',
                'required' => true,
                'disabled' => true,
                'data' => $this->adherent->getFirstname().' '.$this->adherent->getLastname(),
            ))
                ->add('department', null, array(
                    'label' => 'Departement *',
                    'required' => true,
                    'disabled' => true,
                    'data' => $this->adherent->getDepartement(),
            ))
                ->add('date', null, array('label' => "Date de l'élection *"))
                ->add('numberOfVoters', null, array('label' => 'Nombre de votants', 'required' => false))
                ->add('validVotes', null, array('label' => 'Votes exprimés', 'required' => false))
                ->add('blankVotes', null, array('label' => 'Votes blancs', 'required' => false))
                ->add('coSecWomen', 'entity', array(
                    'label' => 'Co-secrétaire femme *',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => true,
                    'class' => 'AppBundle:Adherent',
                    'query_builder' => function (AdherentRepository $repository) {
                        return $repository
                            ->createQueryBuilder('a')
                            ->where('a.departement = :department')
                            ->andWhere('a.gender = :gender')
                            ->setParameter('department', $this->adherent->getDepartement())
                            ->setParameter('gender', 'F');
                    }
                ))
                ->add('oldCoSecWomen', 'entity', array(
                    'label' => 'Ancienne co-secrétaire femme',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => false,
                    'class' => 'AppBundle:Adherent',
                    'query_builder' => function (AdherentRepository $repository) {
                        return $repository
                            ->createQueryBuilder('a')
                            ->where('a.departement = :department')
                            ->andWhere('a.gender = :gender')
                            ->setParameter('department', $this->adherent->getDepartement())
                            ->setParameter('gender', 'F');
                    }
                ))
                ->add('coSecMen', 'entity', array(
                    'label' => 'Co-secrétaire homme *',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => true,
                    'class' => 'AppBundle:Adherent',
                    'query_builder' => function (AdherentRepository $repository) {
                        return $repository
                            ->createQueryBuilder('a')
                            ->where('a.departement = :department')
                            ->andWhere('a.gender = :gender')
                            ->setParameter('department', $this->adherent->getDepartement())
                            ->setParameter('gender', 'M');
                    }
                ))
                ->add('oldCoSecMen', 'entity', array(
                    'label' => 'Ancien co-secrétaire homme',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => false,
                    'class' => 'AppBundle:Adherent',
                    'query_builder' => function (AdherentRepository $repository) {
                        return $repository
                            ->createQueryBuilder('a')
                            ->where('a.departement = :department')
                            ->andWhere('a.gender = :gender')
                            ->setParameter('department', $this->adherent->getDepartement())
                            ->setParameter('gender', 'M');
                    }
                ))
                ->add('coTreasureWomen', 'entity', array(
                    'label' => 'Co-trésorière femme *',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => true,
                    'class' => 'AppBundle:Adherent',
                    'query_builder' => function (AdherentRepository $repository) {
                        return $repository
                            ->createQueryBuilder('a')
                            ->where('a.departement = :department')
                            ->andWhere('a.gender = :gender')
                            ->setParameter('department', $this->adherent->getDepartement())
                            ->setParameter('gender', 'F');
                    }
                ))
                ->add('oldCoTreasureWomen', 'entity', array(
                    'label' => 'Ancienne Co-trésorière femme',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => false,
                    'class' => 'AppBundle:Adherent',
                    'query_builder' => function (AdherentRepository $repository) {
                        return $repository
                            ->createQueryBuilder('a')
                            ->where('a.departement = :department')
                            ->andWhere('a.gender = :gender')
                            ->setParameter('department', $this->adherent->getDepartement())
                            ->setParameter('gender', 'F');
                    }
                ))
                ->add('coTreasureMen', 'entity', array(
                    'label' => 'Co Trésorier homme *',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => true,
                    'class' => 'AppBundle:Adherent',
                    'query_builder' => function (AdherentRepository $repository) {
                        return $repository
                            ->createQueryBuilder('a')
                            ->where('a.departement = :department')
                            ->andWhere('a.gender = :gender')
                            ->setParameter('department', $this->adherent->getDepartement())
                            ->setParameter('gender', 'M');
                    }
                ))
                ->add('oldCoTreasureMen', 'entity', array(
                    'label' => 'Ancien Co-trésorier homme',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => false,
                    'class' => 'AppBundle:Adherent',
                    'query_builder' => function (AdherentRepository $repository) {
                        return $repository
                            ->createQueryBuilder('a')
                            ->where('a.departement = :department')
                            ->andWhere('a.gender = :gender')
                            ->setParameter('department', $this->adherent->getDepartement())
                            ->setParameter('gender', 'M');
                    }
                ))
                ->add('responsability1', null, array(
                    'label' => 'Poste fonctionnel 1',
                    'required' => false,
                    'data' => 'Fonction...'
                ))
                ->add('responsable1', 'entity', array(
                    'label' => 'Elu',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => false,
                    'class' => 'AppBundle:Adherent',
                    'query_builder' => function (AdherentRepository $repository) {
                        return $repository
                            ->createQueryBuilder('a')
                            ->where('a.departement = :department')
                            ->setParameter('department', $this->adherent->getDepartement());
                    }
                ))
                ->add('responsability2', null, array(
                    'label' => 'Poste fonctionnel',
                    'required' => false
                ))
                ->add('responsability3', null, array(
                    'label' => 'Poste fonctionnel',
                    'required' => false
                ))
                ->add('responsability4', null, array(
                    'label' => 'Poste fonctionnel',
                    'required' => false
                ))
                ->add('responsability5', null, array(
                    'label' => 'Poste fonctionnel',
                    'required' => false
                ))
                ->add('responsability6', null, array('
                label' => 'Poste fonctionnel',
                    'required' => false
                ));
        });
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return 'appbundle_election_election';
    }
}