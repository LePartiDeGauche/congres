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
            FOSUserEvents::REGISTRATION_INITIALIZE => 'onRegistrationInitialize',
            FOSUserEvents::REGISTRATION_SUCCESS => array('onRegistrationSuccess', -1),
        );
    }

    /**
     * When user created
     */
    public function onRegistrationSuccess(FormEvent $event)
    {
        $url = $this->router->generate('custom_user_registration_check_email', array(
            'email' => $event->getForm()->getData()->getEmail(),
        ));
        $event->setResponse(new RedirectResponse($url));
    }

    /**
     * If form is valid but profile does not exists.
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

        // If profile exists, registration authorized, FOSUserBundle proceed.
        if ($profile) {
            $user->setProfile($profile);

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
}
