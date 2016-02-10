<?php

namespace AppBundle\Form\Event;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use AppBundle\Form\Type\EntityTableType;

use AppBundle\Entity\Event\EventRoleRepository;
use AppBundle\Entity\Event\EventMealRepository;
use AppBundle\Entity\Event\EventCostRepository;

class EventAdherentRegistrationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($builder) {
            $form = $event->getForm();
            $data = $event->getData();

            /* Check we're looking at the right data/form */
            if (false === $data instanceof \AppBundle\Entity\Event\EventAdherentRegistration) {
                throw new \InvalidArgumentException('Invalid Form data expected EventAdherentRegistration, got '.$data->getClassName());
            }

            $curEvent = $data->getEvent();
            $curAdherent = $data->getAdherent();

            $form->add('author', 'text', array(
                'data_class' => 'AppBundle\Entity\Adherent',
                'label' => 'Utilisateur',
                'disabled' => 'true'
            ));

            if ($curAdherent != null) {
                $form->add('role', 'entity', array(
                    'class' => 'AppBundle\Entity\Event\EventRole',
                    'query_builder' => function (EventRoleRepository $er) use ($curEvent, $curAdherent) {
                        return $er->findByEventAndAdherentQueryBuider($curEvent, $curAdherent);
                    },
                    'expanded' => false,
                    'multiple' => false,
                ));
            }

            if ($curEvent->getIsRolesCommentEnabled()) {
                $roleCommentOptions = array(
                    'label' => 'Commentaire sur le rôle',
                );
                if ( ($helpText = $curEvent->getRolesCommentHelpText()) &&
                    !empty($helpText)
                ) {
                    $roleCommentOptions['attr'] = array(
                        'data-help' => $helpText,
                    );
                }
                $form->add('roleComment', 'text', $roleCommentOptions);
            }

            $form->add('meals', 'entity', array(
                'class' => 'AppBundle\Entity\Event\EventMeal',
                'choices' => $curEvent->getMeals(),
                'expanded' => true,
                'multiple' => true,
                'label' => 'Repas',
                'label_attr' => array(
                    'class' => 'checkbox-inline'
                )
            ));

            $form->add('sleepingType', 'entity', array(
                'class' => 'AppBundle\Entity\Event\EventSleepingType',
                'choices' => $curEvent->getSleepingTypes(),
                'expanded' => true,
                'multiple' => false,
                'label' => 'Type d\'hébergement',
            ));

            $form->add('comment', null, array(
                'label' => 'Commentaire(s)',
            ));

        });
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Event\EventAdherentRegistration',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_event_eventadherentregistration';
    }
}
