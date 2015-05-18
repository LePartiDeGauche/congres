<?php

namespace AppBundle\Form\Text;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Entity\Text\TextRepository;

class AmendmentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $textGroupId = $options['text_group_id'];
        $textOptions = array(
            'label' => 'Texte concerné',
            'expanded' => false,
            'multiple' => false,
            'class' => 'AppBundle\Entity\Text\Text',
            'query_builder' => function(TextRepository $er) use ($textGroupId){
                $qb = $er->createQueryBuilder('t');
                if (isset($textGroupId)) {
                    $qb->where('t.textGroup = :textGroupId')
                        ->setParameter(':textGroupId', $textGroupId);
                }
                $qb->orderBy('t.title', 'ASC');
                return $qb;
            }
        );
        $builder->add('text', 'entity', $textOptions)
            ->add('startLine', null, array('label' => 'Index ligne de début'))
            ->add('type', 'choice', array(
                'label' => 'Type de modification',
                'choices' => array(
                    'a' => 'Ajout', 'd' => 'Suppression', 'm' => 'Modification'
                )))
            ->add('content', null, array('label' => 'Nouveau texte'))
            ->add('meetingDate', null, array('label' => 'Date de réunion'))
            ->add('numberOfPresent', null, array('label' => 'Nombre de présents'))
            ->add('save', 'submit', array('label' => 'Enregistrer'))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Text\Amendment',
            'text_group_id' => null
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_text_amendment';
    }
}
