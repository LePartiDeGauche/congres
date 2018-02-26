<?php

namespace AppBundle\Form\Text;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TextType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('depositor', 'text', array(
                'label' => 'Déposant',
                'data_class' => 'AppBundle\Entity\Adherent',
                'disabled' => true
            ))
            ->add('author', 'autocomplete', array(
                'label' => 'Mandataire',
                'class' => 'AppBundle:Adherent',
                'required' => true,
                'attr' => array(
                    'data-help' => 'Merci de renseigner le nom du mandataire, le cas échéant.
                                    Vous devez lancer une recherche suivant son nom, son prénom ou son email, puis le sélectionner dans la liste.'
                )
            ))
            ->add('authorInfo', null, array(
                'label' => 'Informations de contact',
                'required' => false,
                'attr' => array(
                    'data-help' => 'Merci de renseigner les informations de contact du <b>mandataire</b>: numéro de téléphone, adresse mail, etc.'
                )
            ))
            ->add('title', null, array('label' => 'Titre'))
            ->add('rawContent', null, array(
                'label' => 'Contenu',
                'required' => true,
                'attr' => array(
                    'class' => 'tinymce',
                    'data-theme' => 'markdown',
                )
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Text\Text',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_text_text';
    }
}
