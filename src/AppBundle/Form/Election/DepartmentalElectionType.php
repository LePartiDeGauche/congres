<?php

namespace AppBundle\Form\Election;

use AppBundle\Entity\Adherent;
use AppBundle\Entity\Organ;
use AppBundle\Entity\AdherentRepository;
use AppBundle\Entity\Responsability;
use AppBundle\Entity\ResponsabilityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class DepartmentalElectionType extends AbstractType
{
    private $adherent;

    private $departement;

    public function __construct(Adherent $adherent, $departement)
    {
        $this->adherent = $adherent;
        $this->departement = $departement;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $departement = $this->departement;
            $departmentalElection = $event->getData();
            $form = $event->getForm();

            $adherentFemaleQueryBuilder = function (AdherentRepository $repository) use ($departement) {
                return $repository->getSearchAdherentByOrganQueryBuilder($departement)
                    ->andWhere('a.gender = :gender')
                    ->setParameter('gender', 'F')
                    ->orderBy('a.lastname', 'ASC');
            };
            $adherentMaleQueryBuilder = function (AdherentRepository $repository) use ($departement) {
                return $repository->getSearchAdherentByOrganQueryBuilder($departement)
                    ->andWhere('a.gender = :gender')
                    ->setParameter('gender', 'M')
                    ->orderBy('a.lastname', 'ASC');
            };
            $adherentQueryBuilder = function (AdherentRepository $repository) use ($departement) {
                return $repository->getSearchAdherentByOrganQueryBuilder($departement)
                                  ->orderBy('a.lastname', 'ASC');;
            };
            $responsabilityQueryBuilder = function (ResponsabilityRepository $repository) {
                return $repository->createQueryBuilder('r')
                                  ->where('r.name in (:names)')
                                  ->setParameter('names', array('Matériel',
                                          'Relations unitaires',
                                          'Relations presse locale',
                                          'Medias du parti',
                                          'Elections',
                                          'Responsable fichier'));
            };


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
                    'data' => $departement->getDescription(),
            ))
                ->add('date', 'date', array('label' => "Date de l'élection *"))
                ->add('numberOfVoters', 'integer', array(
                    'label' => 'Nombre de votants',
                    'required' => false,
                    'attr' => array(
                        'min' => '1',
                    ), ))
                ->add('validVotes', 'integer', array(
                    'label' => 'Votes exprimés',
                    'attr' => array(
                        'min' => '1',
                    ), ))
                ->add('blankVotes',
                    'integer', array(
                    'label' => 'Votes blancs',
                    'required' => false,
                        'attr' => array(
                           'min' => '1',
                    ), ))
                ->add('coSecWomen', 'entity', array(
                    'label' => 'Co-secrétaire femme *',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => false,
                    'placeholder' => 'Poste vacant',
                    'property' => 'getUpperNames',
                    'class' => 'AppBundle:Adherent',
                    'query_builder' => $adherentFemaleQueryBuilder
                ))
                ->add('oldCoSecWomen', 'entity', array(
                    'label' => 'Ancienne co-secrétaire femme',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => false,
                    'placeholder' => 'Poste vacant',
                    'property' => 'getUpperNames',
                    'class' => 'AppBundle:Adherent',
                    'query_builder' => $adherentFemaleQueryBuilder
                ))
                ->add('coSecMen', 'entity', array(
                    'label' => 'Co-secrétaire homme *',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => false,
                    'placeholder' => 'Poste vacant',
                    'property' => 'getUpperNames',
                    'class' => 'AppBundle:Adherent',
                    'query_builder' => $adherentMaleQueryBuilder
                ))
                ->add('oldCoSecMen', 'entity', array(
                    'label' => 'Ancien co-secrétaire homme',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => false,
                    'placeholder' => 'Poste vacant',
                    'property' => 'getUpperNames',
                    'class' => 'AppBundle:Adherent',
                    'query_builder' => $adherentMaleQueryBuilder
                ))
                ->add('coTreasureWomen', 'entity', array(
                    'label' => 'Co-trésorière femme *',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => false,
                    'placeholder' => 'Poste vacant',
                    'property' => 'getUpperNames',
                    'class' => 'AppBundle:Adherent',
                    'query_builder' => $adherentFemaleQueryBuilder
                ))
                ->add('oldCoTreasureWomen', 'entity', array(
                    'label' => 'Ancienne Co-trésorière femme',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => false,
                    'placeholder' => 'Poste vacant',
                    'property' => 'getUpperNames',
                    'class' => 'AppBundle:Adherent',
                    'query_builder' => $adherentFemaleQueryBuilder
                ))
                ->add('coTreasureMen', 'entity', array(
                    'label' => 'Co Trésorier homme *',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => false,
                    'placeholder' => 'Poste vacant',
                    'property' => 'getUpperNames',
                    'class' => 'AppBundle:Adherent',
                    'query_builder' => $adherentMaleQueryBuilder
                ))
                ->add('oldCoTreasureMen', 'entity', array(
                    'label' => 'Ancien Co-trésorier homme',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => false,
                    'placeholder' => 'Poste vacant',
                    'property' => 'getUpperNames',
                    'class' => 'AppBundle:Adherent',
                    'query_builder' => $adherentMaleQueryBuilder
                ));

                for ($i=1; $i < 18; $i++) {
                    $form->add('delegueCNTitulaire' . $i, 'entity', array(
                        'label' => 'Délégué(e) CN Titulaire ' . $i,
                        'expanded' => false,
                        'multiple' => false,
                        'required' => false,
                        'property' => 'getUpperNames',
                        'class' => 'AppBundle:Adherent',
                        'query_builder' =>  $adherentQueryBuilder
                    ))
                    ->add('delegueCNSuppleant' . $i, 'entity', array(
                        'label' => 'Délégué(e) CN Suppléant(e) ' . $i,
                        'expanded' => false,
                        'multiple' => false,
                        'required' => false,
                        'property' => 'getUpperNames',
                        'class' => 'AppBundle:Adherent',
                        'query_builder' =>  $adherentQueryBuilder
                    ));
                }

                for ($i=1; $i < 7; $i++) {
                    $form->add('responsability' . $i, 'entity', array(
                        'label' => 'Poste fonctionnel ' . $i,
                        'required' => false,
                        'expanded' => false,
                        'multiple' => false,
                        'class' => 'AppBundle:Responsability',
                        'query_builder' => $responsabilityQueryBuilder
                    ))
                    ->add('responsable' . $i, 'entity', array(
                        'label' => 'Elu à ce poste',
                        'expanded' => false,
                        'multiple' => false,
                        'required' => false,
                        'property' => 'getUpperNames',
                        'class' => 'AppBundle:Adherent',
                        'query_builder' =>  $adherentQueryBuilder
                    ));
                }
        });
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_election_election';
    }
}
