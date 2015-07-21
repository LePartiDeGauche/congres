<?php

namespace AppBundle\EventListener;

use Doctrine\ORM\EntityManager;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use AppBundle\Entity\Adherent;

/**
 * Listener responsible for sending an email and prevent registration if
 * profile does not exists.
 */
class RegistrationListener implements EventSubscriberInterface
{
    private $router;

    private $templating;

    private $mailer;

    private $em;

    private $userManager;

    private $formFactory;

    public function __construct(
        UrlGeneratorInterface $router,
        EngineInterface $templating,
        \Swift_Mailer $mailer,
        EntityManager $em,
        $userManager,
        $formFactory
    ) {
        $this->router = $router;
        $this->templating = $templating;
        $this->mailer = $mailer;
        $this->em = $em;
        $this->userManager = $userManager;
        $this->formFactory = $formFactory;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            //FOSUserEvents::REGISTRATION_INITIALIZE => 'onRegistrationInitialize',
            //FOSUserEvents::REGISTRATION_SUCCESS => array('onRegistrationSuccess', -1),
            FOSUserEvents::REGISTRATION_CONFIRM => 'onRegistrationConfirm',
        );
    }

    /**
     * When user created we link adherent profile to user.
     */
    public function onRegistrationSuccess(FormEvent $event)
    {
        $user = $event->getForm()->getData();
        //TODO:
        $profile = $this->em
            ->getRepository('AppBundle:Adherent')
            ->findOneByEmail($user->getEmail());
        $user->setProfile($profile);

        $url = $this->router->generate('custom_user_registration_check_email', array(
            'email' => $user->getEmail(),
        ));
        $event->setResponse(new RedirectResponse($url));
    }

    /**
     * If form is valid but profile does not exists, we fake correct registration
     * otherwise anyone could known who is member of the Parti de Gauche.
     */
    public function onRegistrationInitialize(GetResponseUserEvent $event)
    {
        $user = $this->userManager->createUser();
        $form = $this->formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($event->getRequest());

        // If form invalid, FOSUserBundle proceed.
        if (!$form->isValid()) {
            return;
        }

        $profile = $this->em
            ->getRepository('AppBundle:Adherent')
            ->findOneByEmail($user->getEmail());

        // TODO : Change hard coded status enum to an real ADherentStatus Entity
        // If profile exists, and adherent is allowed to register, registration is authorized, FOSUserBundle proceed.
        if ($profile  && (Adherent::STATUS_OK === $profile->getStatus() || Adherent::STATUS_ATTENTE_RENOUVELLEMENT === $profile->getStatus())) {
            return true;
        }

        // If profile does not exist, we send an email and redirect as if success.

        $message = \Swift_Message::newInstance()
            ->setFrom('congres@lepartidegauche.fr')
            ->setSubject('Adresse email inconnue.')
            ->setTo($user->getEmail())
            ->setBody(
                $this->templating->render(
                    'mail/unkown_email_address.txt.twig',
                    array('email' => $user->getEmail())
                )
            );

        $this->mailer->send($message);

        $url = $this->router->generate('custom_user_registration_check_email', array(
            'email' => $user->getEmail(),
        ));
        $event->setResponse(new RedirectResponse($url));
    }

    public function onRegistrationConfirm(GetResponseUserEvent $event)
    {
        $profile = $this->em
            ->getRepository('AppBundle:Adherent')
            ->findOneByEmail($event->getUser()->getEmail());

        if ($profile !== null) {
            $event->getUser()->setProfile($profile);
        } else {
            //$event->getUser()->setEnabled(false);
            $url = $this->router->generate('non_adherent_register');
            $event->setResponse(new RedirectResponse($url));
            return false;
        }
    }
}
