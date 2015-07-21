<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use AppBundle\Entity\Event\Event;
use AppBundle\Entity\Adherent;
use AppBundle\Entity\Event\EventAdherentRegistration;
use AppBundle\Form\Event\EventAdherentRegistrationType;
use AppBundle\Entity\Payment\EventPayment;

/**
 * Event\Event controller.
 *
 * @Route("/event")
 */
class EventController extends Controller
{
    /**
     * Finds and displays a Event\EventAdherentRegistration entity.
     *
     * @Route("/{event_id}/registration/{event_reg_id}", name="event_registration_show", requirements={
     *     "event_id": "\d+",
     *     "event_reg_id": "\d+"
     *     })
     *
     * @Method("GET")
     * @ParamConverter("event", class="AppBundle:Event\Event", options={"id" = "event_id"})
     * @ParamConverter("eventRegistration", class="AppBundle:Event\EventAdherentRegistration", options={"id" = "event_reg_id"})
     * @Template("event/registration_show.html.twig")
     */
    public function registrationShowAction(Event $event, EventAdherentRegistration $eventRegistration)
    {
        if ($eventRegistration->getAuthor() !=  $this->getUser()->getProfile()) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository("AppBundle:Event\EventAdherentRegistration");

        $payedAmount = $repo->getPayedAmountById($eventRegistration);

        return array(
            'event' => $event,
            'eventRegistration' => $eventRegistration,
            'payedAmount' => $payedAmount,
        );
    }

    /**
     * Make a new payment for Event\EventAdherentRegistration entity.
     *
     * @Route("/{event_id}/registration/{event_reg_id}/payment",
     *  name="event_registration_new_payment", requirements={
     *     "event_id": "\d+",
     *     "event_reg_id": "\d+"
     *     })
     *
     * @Method("GET")
     * @ParamConverter("event", class="AppBundle:Event\Event", options={"id" = "event_id"})
     * @ParamConverter("eventRegistration", class="AppBundle:Event\EventAdherentRegistration",
     * options={"id" = "event_reg_id"})
     */
    public function registrationNewPaymentAction(Event $event, EventAdherentRegistration $eventRegistration)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository("AppBundle:Event\EventAdherentRegistration");
        $payedAmount = $repo->getPayedAmountById($eventRegistration);
        $cost = $eventRegistration->getCost()->getCost();
        $adherent = $this->getUser()->getProfile();

        if ($payedAmount < $cost) {
            $payment = $this->createPayment($adherent, $event, $eventRegistration, $cost - $payedAmount);

            $em->persist($payment);
            $em->flush();

            return $this->redirect($this->generateUrl('payment_pay',
                array('id' => $payment->getId())));
        }

        return $this->redirect($this->generateUrl('event_registration_show',
            array('event_id' => $event->getId(), 'event_reg_id' => $eventRegistration->getId())));
    }

    /**
     * Register to a event.
     *
     * @Route("/{event_id}/registration/create", name="event_registration_create", requirements={
     *     "event_id": "\d+"
     *     })
     * @ParamConverter("event", class="AppBundle:Event\Event", options={"id" = "event_id"})
     */
    public function registerAction(Request $request, Event $event)
    {
        $this->denyAccessUnlessGranted('event-register', $event, 'Vous ne disposez pas des droits nécessaires pour vous inscrire.');

        $adherent = $this->getUser()->getProfile();
        $em = $this->getDoctrine()->getManager();

        $eventRegistration = $this->getDoctrine()
            ->getRepository('AppBundle:Event\EventAdherentRegistration')
            ->findOneBy(array('adherent' => $adherent, 'event' => $event));

        if ($eventRegistration) {
            return $this->redirect($this->generateUrl('event_registration_show',
                array('event_id' => $event->getId(), 'event_reg_id' => $eventRegistration->getId())));
        }

        // TODO voter (no time for this now...)
        $now = new \DateTime('now');
        if ($now < $event->getRegistrationBegin() || $now > $event->getRegistrationEnd()) {
            throw new AccessDeniedException('Les inscriptions ne sont pas ouvertes');
        }

        $eventRegistration = new EventAdherentRegistration($this->getUser()->getProfile(), $event);

        $eventRegistration->setAdherent($adherent);
        $form = $this->createRegistrationCreateForm($eventRegistration, $event);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $eventRegistration = $form->getData();
            $needHosting = $eventRegistration->getNeedHosting();
            $eventRegistration->setEvent($event);
            $eventRegistration->setRegistrationDate(new \DateTime('now'));
            $eventRegistration->setAdherent($adherent);

            $em->persist($eventRegistration);
            $em->flush();

            // FIXME: activer la sélection de chambre devrait être une préférence
            // définie pour l'événement
            if ($needHosting == true && FALSE){
                /** @var Session $session */
                $session = $this->get('session');

                $session->set('paiement', $eventRegistration->getPaymentMode());
                return $this->redirect($this->generateUrl('sleeping_list'));
            }

            $message = \Swift_Message::newInstance()
                ->setSubject('Inscription Remues Méninges 2015')
                ->setTo($this->getUser()->getEmail())
                ->setBody(
                    $this->renderView(
                        'mail/event_register.txt.twig',
                        array('email' => $user->getEmail())
                    )
                );
            $this->get('mailer')->send($message);

            if ($eventRegistration->getPaymentMode() == EventAdherentRegistration::PAYMENT_MODE_ONLINE) {
                $eventPayment = $this->createPayment($adherent, $event, $eventRegistration, $eventRegistration->getCost()->getCost());
                $em->persist($eventPayment);
                $em->flush();

                return $this->redirect($this->generateUrl('payment_pay',
                    array('id' => $eventPayment->getId())));
            } else {
                return $this->redirect($this->generateUrl('event_registration_show',
                    array('event_id' => $event->getId(), 'event_reg_id' => $eventRegistration->getId())));
            }
        }

        return $this->render('event/registration.html.twig', array(
            'event' => $event,
            'event_registration' => $eventRegistration,
            'form' => $form->createView(), ))
            ;
    }

    /**
     * Finds and displays a Event\Event entity.
     *
     * @Route("/{event_id}", name="event_show", requirements={
     *     "event_id": "\d+"
     * })
    )
     * @Method("GET")
     * @ParamConverter("event", class="AppBundle:Event\Event", options={"id" = "event_id"})
     * @Template("event/show.html.twig")
     */
    public function showAction(Event $event)
    {
        return array(
            'event' => $event,
        );
    }

    /**
     * Lists all Event\EventAdherentRegistration entities.
     *
     * @Route("/registration/user", name="event_adherent_registration_list")
     *
     * @Method("GET")
     */
    public function indexAction()
    {
        $adherent = $this->getUser()->getProfile();
        $em = $this->getDoctrine()->getManager();

        $eventRegs = $em->getRepository('AppBundle:Event\EventAdherentRegistration')->findByAuthor($adherent);

        return $this->render('event/adherent_registration_list.html.twig', array(
            'eventRegistrations' => $eventRegs,
            'adherent' => $adherent,
        ));
    }

    /**
     * Creates a form to create a Event\EventAdherentRegistration entity.
     *
     * @param EventAdherentRegistration $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createRegistrationCreateForm(EventAdherentRegistration $entity, Event $event)
    {
        $form = $this->createForm(new EventAdherentRegistrationType(), $entity, array(
            'action' => $this->generateUrl('event_registration_create', array('event_id' => $event->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    private function createPayment(Adherent $adherent, Event $event, EventAdherentRegistration $eventRegistration, $amount)
    {
        $eventPayment = new EventPayment($adherent, $event, $eventRegistration, $amount);
        $eventPayment->setAmount($amount)
            ->setMethod(EventPayment::METHOD_CREDIT_CARD)
            ->setStatus(EventPayment::STATUS_NEW)
            ->setDrawer($adherent)
            ->setRecipient($adherent)
            ->setDate(new \DateTime('now'))
            ->setReferenceIdentifierPrefix($event->getNormalizedName())
            ->setAccount(EventPayment::ACCOUNT_PG); // FIXME : multiple account gestion, the account as to be choosen when creating the event. Needed to modify PayboxBundle to manage multiple id

        return $eventPayment;
    }
}
