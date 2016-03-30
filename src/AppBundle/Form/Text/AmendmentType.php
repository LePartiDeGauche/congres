<?php

namespace AppBundle\Form\Text;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use AppBundle\Entity\Text\TextRepository;

class AmendmentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $em = $options['em'];

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($em) {
            $amendment = $event->getData();
            $form = $event->getForm();

            // check if the Product object is "new"
            // If no data is passed to the form, the data is "null".
            // This should be considered a new "Product"
            if (!$amendment || null === $amendment->getId()) {
                // $form->add('name', TextType::class);
            }

            $organTypes = array();
            $ruleTerms = $amendment->getAmendmentProcess()->getParticipationRule()->getParticipationRuleTerms();
            foreach ($ruleTerms as $ruleTerm) {
                $organTypes[] = $ruleTerm->getOrganType();
            }
            $choices = $em->getRepository('AppBundle:Organ\Organ')
                          ->getOrganByAdherentAndTypes($amendment->getAuthor(), $organTypes);

            $form->add('text', 'entity', array(
                'label' => 'Texte concerné',
                'class' => 'AppBundle\Entity\Text\Text',
                'choices' => $amendment->getAmendmentProcess()->getTextGroup()->getTexts(),
                'disabled' => (count($amendment->getAmendmentProcess()->getTextGroup()->getTexts()) == 1),
            ))
            ->add('author', 'text', array(
                'data_class' => 'AppBundle\Entity\Adherent',
                'label' => 'Rapporteur',
                'disabled' => 'true'
            ))
            ->add('organ', 'entity', array(
                'class' => 'AppBundle\Entity\Organ\Organ',
                'label' => 'Organe',
                'choices' => $choices
            ))
            ->add('meetingDate', 'sonata_type_date_picker', array(
                'format' => 'd/M/y',
                'label' => 'Date de réunion',
            ))
            ->add('numberOfPresent', null, array('label' => 'Nombre de présents'))
            ->add('amendmentTopic', 'entity', array(
                'label' => 'Thème',
                'class' => 'AppBundle\Entity\Process\AmendmentTopic',
            ))
            ->add('nature', 'choice', array(
                'label' => 'Nature de la modification',
                'choices' => array(
                    'o' => 'Fond', 'r' => 'Forme',
                ),
                'expanded' => true,
                'multiple' => false,
            ))
            ->add('startLine', null, array('label' => 'Lignes concernées de'))
            ->add('endLine', null, array('label' => 'à'))
            ->add('type', 'choice', array(
                'label' => 'Type de modification',
                'choices' => array(
                    'a' => 'Ajout', 'd' => 'Suppression', 'm' => 'Modification',
                ),
                'expanded' => true,
                'multiple' => false,
            ))
            ->add('content', null, array(
                'label' => 'Amendement rédigé',
                'attr' => array(
                    'maxlength' => '1500',
                    'data-help' => '1500 signes maximum'
                ),
            ))
            ->add('explanation', null, array(
                'label' => 'Motivations',
                'attr' => array(
                    'maxlength' => '600',
                    'data-help' => '600 signes maximum'
                ),
            ))
            ->add('save', 'submit', array('label' => 'Enregistrer'))
            ;
        });
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Text\Amendment',
        ));
        $resolver->setRequired(array('em'));
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'AppBundle\Entity\Text\Amendment',
            'em' => null,
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_text_amendment';
    }
}
