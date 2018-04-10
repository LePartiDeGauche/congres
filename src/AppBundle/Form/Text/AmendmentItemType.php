<?php

namespace AppBundle\Form\Text;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use AppBundle\Entity\Text\TextRepository;
use AppBundle\Entity\Text\AmendmentItem;

class AmendmentItemType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $amendmentItem = $event->getData();
            $form = $event->getForm();

            if (!$amendmentItem || null === $amendmentItem->getId()) {
                // $form->add('name', TextType::class);
            }

            $form->add('text', 'entity', array(
                'label' => 'Texte concerné',
                'class' => 'AppBundle\Entity\Text\Text',
                'choices' => $amendmentItem->getAmendmentDeposit()->getAmendmentProcess()->getTextGroup()->getTexts(),
                'disabled' => (count($amendmentItem->getAmendmentDeposit()->getAmendmentProcess()->getTextGroup()->getTexts()) == 1),
            ))
            ->add('type', 'choice', array(
                'label' => 'Type de modification',
                'choices' => AmendmentItem::getTypes(),
                'expanded' => true,
            ))
            ->add('startLine', null, array('label' => 'Ligne de début'))
            ->add('endLine', null, array('label' => 'Ligne de fin'))
            ->add('content', null, array('label' => 'Contenu'))
            ->add('explanation', null, array('label' => 'Motif'))
            ->add('forVote', null, array('label' => 'Votes pour'))
            ->add('againstVote', null, array('label' => 'Votes contre'))
            ->add('abstentionVote', null, array('label' => 'Abstention'))
            ->add('dtpvVote', null, array('label' => 'NPPV'))
            ->add('save', 'submit', array('label' => 'Ajouter l\'amendement'))
            ;
        });
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Text\AmendmentItem',
        ));
        // $resolver->setRequired(array('em'));
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'AppBundle\Entity\Text\AmendmentItem',
            // 'em' => null,
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_text_amendment_item';
    }
}
