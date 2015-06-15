<?php

namespace AppBundle\Form\Election;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use AppBundle\Entity\Responsability;
use AppBundle\Entity\ResponsabilityRepository;

class CandidatureType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('responsability', 'entity', array(
                'label' => 'Instance',
                'class' => 'AppBundle:Responsability',
                'query_builder' => function (ResponsabilityRepository $er) {
                    $qb = $er->createQueryBuilder('t');
                    $qb->where('t.name IN (:names)')
                        ->setParameter(':names', array(
                            Responsability::INSTANCE_BN,
                            Responsability::INSTANCE_BC,
                            Responsability::INSTANCE_CDC,
                            Responsability::INSTANCE_SEN,
                            Responsability::INSTANCE_CRC,
                            Responsability::INSTANCE_CCF,
                            Responsability::INSTANCE_CN_NAT,
                        ));
                    $qb->orderBy('t.name', 'ASC');

                    return $qb;
                },
            ))
            ->add('professionfoi', null, array('label' => 'Profession de foi'))
            ->add('isSortant', 'checkbox', array(
                'label'     => 'Je suis candidat-e sortant-e d\'une instance nationale.',
                'required'  => false,
            ))
            ->add('professionfoicplt', null, array('label' => 'Complément'))
            ->add('save', 'submit', array('label' => 'Enregistrer'));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Election\Candidature',
            'text_group_id' => null,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_election_candidature';
    }
}
