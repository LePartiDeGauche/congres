<?php

namespace AppBundle\Form\Election;

use AppBundle\Entity\Adherent;
use AppBundle\Entity\AdherentRepository;
use AppBundle\Entity\Election\Election;
use AppBundle\Entity\Responsability;
use AppBundle\Entity\ResponsabilityRepository;
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

            $form->add('responsableElection', null, array(
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
                ->add('date', 'date', array('label' => "Date de l'élection *"))
                ->add('numberOfVoters', 'integer', array(
                    'label' => 'Nombre de votants',
                    'required' => false,
                    'attr' => array(
                        'min' => '1'
                    )))
                ->add('validVotes', 'integer', array(
                    'label' => 'Votes exprimés',
                    'attr' => array(
                        'min' => '1'
                    )))
                ->add('blankVotes',
                    'integer', array(
                    'label' => 'Votes blancs',
                    'required' => false,
                        'attr' => array(
                           'min' => '1'
                    )))
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
                ->add('responsability1', 'entity', array(
                    'label' => 'Poste fonctionnel 1',
                    'required' => false,
                    'expanded' => false,
                    'multiple' => false,
                    'class' => 'AppBundle:Responsability',
                    'query_builder' => function (ResponsabilityRepository $repository) {
                        return $repository
                            ->createQueryBuilder('r');
                    }
                ))
                ->add('responsable1', 'entity', array(
                    'label' => 'Elu à ce poste',
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
                ->add('responsability2', 'entity', array(
                    'label' => 'Poste fonctionnel 2',
                    'required' => false,
                    'expanded' => false,
                    'multiple' => false,
                    'class' => 'AppBundle:Responsability',
                    'query_builder' => function (ResponsabilityRepository $repository) {
                        return $repository
                            ->createQueryBuilder('r');
                    }
                ))
                ->add('responsable2', 'entity', array(
                    'label' => 'Elu à ce poste',
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
                ->add('responsability3', 'entity', array(
                    'label' => 'Poste fonctionnel 3',
                    'required' => false,
                    'expanded' => false,
                    'multiple' => false,
                    'class' => 'AppBundle:Responsability',
                    'query_builder' => function (ResponsabilityRepository $repository) {
                        return $repository
                            ->createQueryBuilder('r');
                    }
                ))
                ->add('responsable3', 'entity', array(
                    'label' => 'Elu à ce poste',
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
                ->add('responsability4', 'entity', array(
                    'label' => 'Poste fonctionnel 4',
                    'required' => false,
                    'expanded' => false,
                    'multiple' => false,
                    'class' => 'AppBundle:Responsability',
                    'query_builder' => function (ResponsabilityRepository $repository) {
                        return $repository
                            ->createQueryBuilder('r');
                    }
                ))
                ->add('responsable4', 'entity', array(
                    'label' => 'Elu à ce poste',
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
                ->add('responsability5', 'entity', array(
                    'label' => 'Poste fonctionnel 5',
                    'required' => false,
                    'expanded' => false,
                    'multiple' => false,
                    'class' => 'AppBundle:Responsability',
                    'query_builder' => function (ResponsabilityRepository $repository) {
                        return $repository
                            ->createQueryBuilder('r');
                    }
                ))
                ->add('responsable5', 'entity', array(
                    'label' => 'Elu à ce poste',
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
                ->add('responsability6', 'entity', array(
                    'label' => 'Poste fonctionnel 6',
                    'required' => false,
                    'expanded' => false,
                    'multiple' => false,
                    'class' => 'AppBundle:Responsability',
                    'query_builder' => function (ResponsabilityRepository $repository) {
                        return $repository
                            ->createQueryBuilder('r');
                    }
                ))
                ->add('responsable6', 'entity', array(
                    'label' => 'Elu à ce poste',
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