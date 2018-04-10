<?php

namespace AppBundle\Form\Text;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use AppBundle\Entity\Text\TextRepository;

class AmendmentDepositType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $em = $options['em'];

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($em) {
            $amendmentDeposit = $event->getData();
            $form = $event->getForm();

            // check if the Product object is "new"
            // If no data is passed to the form, the data is "null".
            // This should be considered a new "Product"
            if (!$amendmentDeposit || null === $amendmentDeposit->getId()) {
                // $form->add('name', TextType::class);
            }

            $organTypes = array();
            $ruleTerms = $amendmentDeposit->getAmendmentProcess()->getParticipationRule()->getParticipationRuleTerms();
            foreach ($ruleTerms as $ruleTerm) {
                $organTypes[] = $ruleTerm->getOrganType();
            }
            $choices = $em->getRepository('AppBundle:Organ\Organ')
                          ->getOrganByAdherentAndTypes($amendmentDeposit->getMandatary(), $organTypes);

            $form->add('depositor', 'text', array(
                'data_class' => 'AppBundle\Entity\Adherent',
                'label' => 'Rapporteur',
                'disabled' => 'true'
            ))
            ->add('mandatary', 'autocomplete', array(
                'label' => 'Mandataire',
                'class' => 'AppBundle:Adherent',
                'required' => true,
                'attr' => array(
                    'data-help' => 'Merci de renseigner le nom du mandataire, le cas échéant.
                                    Vous devez lancer une recherche suivant son nom, son prénom ou son email, puis le sélectionner dans la liste.'
                )
            ))
            ->add('mandataryInfo', 'text', array(
                'label' => 'Fonction du-de la mandataire',
                'attr' => array(
                    'data-help' => 'Merci de renseigner obligatoirement la fonction du-de la mandataire: co-secrétaire départemental.e / responsable de commission (précisez) / autre (précisez)',
                    'class' => 'contact-info'
                )
            ))
            ->add('origin', 'choice', array(
                'label' => 'Type d\'origine de l\'amendement',
                'choices' => array(
                    'Département',
                    'SEN',
                    'Commission',
                    '6 membres du CN',
                    '50 adhérent.e.s'
                )
            ))
            ->add('originInfo', 'text', array(
                'label' => 'Précision sur l\'origine',
                'attr' => array(
                    'data-help' => 'Merci de préciser l\'origine de l\'amendement: nom du département ou de la commission notamment',
                    'class' => 'contact-info'
                )
            ))
            ->add('meetingDate', 'date', array(
                'label' => 'Date de la réunion',
                'html5' => true,
            ))
            ->add('meetingPlace', 'text', array(
                'label' => 'Lieu de la réunion',
            ))
            ->add('numberOfPresent', null, array(
                'label' => 'Nombre de présents'
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
            'data_class' => 'AppBundle\Entity\Text\AmendmentDeposit',
        ));
        $resolver->setRequired(array('em'));
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'AppBundle\Entity\Text\AmendmentDeposit',
            'em' => null,
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_text_amendment_deposit';
    }
}
