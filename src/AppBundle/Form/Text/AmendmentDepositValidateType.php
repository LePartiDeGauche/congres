<?php

namespace AppBundle\Form\Text;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use AppBundle\Entity\Text\TextRepository;

class AmendmentDepositValidateType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $amendmentDeposit = $event->getData();
            $form = $event->getForm();

            // check if the Product object is "new"
            // If no data is passed to the form, the data is "null".
            // This should be considered a new "Product"
            if (!$amendmentDeposit || null === $amendmentDeposit->getId()) {
                // $form->add('name', TextType::class);
            }

            $form->add('minutesDocumentFile', 'file', array(
                'label' => 'Déposer le procès verbal',
                'required' => false,
                'attr' => array(
                    'data-help' => 'Fichier de type image, document ou tableur',
                    'class' => 'contact-info'
                )
            ))
            ->add('tallySheetFile', 'file', array(
                'label' => 'Déposer la liste d\'émargement',
                'required' => false,
                'attr' => array(
                    'data-help' => 'Fichier de type image, document ou tableur',
                    'class' => 'contact-info'
                )
            ))
            ->add('save', 'submit', array('label' => 'Valider le dépôt d\'amendements'))
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
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'AppBundle\Entity\Text\AmendmentDeposit',
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
