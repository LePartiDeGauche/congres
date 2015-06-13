<?php

namespace AppBundle\Form\Election;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CandidatureType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // $textGroupId = $options['text_group_id'];
        // $textOptions = array(
        //     'label' => 'Texte concerné',
        //     'expanded' => false,
        //     'multiple' => false,
        //     'class' => 'AppBundle\Entity\Text\Text',
        //     'query_builder' => function (TextRepository $er) use ($textGroupId) {
        //         $qb = $er->createQueryBuilder('t');
        //         if (isset($textGroupId)) {
        //             $qb->where('t.textGroup = :textGroupId')
        //                 ->setParameter(':textGroupId', $textGroupId);
        //         }
        //         $qb->orderBy('t.title', 'ASC');
        //
        //         return $qb;
        //     },
        // );

        $builder->add('responsability', 'entity', array(
                'class' => 'AppBundle:Responsability',
            ))
            ->add('professionfoi', null)
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
