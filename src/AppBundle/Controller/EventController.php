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
use AppBundle\Form\Event\EventRegistrationPayType;
use AppBundle\Form\Event\EventCost;
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
            // If it has already payed, redirect to show
            if ($eventRegistration->isPaid()) {
                return $this->redirect($this->generateUrl('event_registration_show', array(
                    'event_id' => $event->getId(),
                    'event_reg_id' => $eventRegistration->getId()
                )));
            }
        } else {
            $eventRegistration = new EventAdherentRegistration($this->getUser()->getProfile(), $event);
        }

        $eventRegistration->setAdherent($adherent);
        $form = $this->createRegistrationCreateForm($eventRegistration, $event);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $eventRegistration = $form->getData();
            $eventRegistration->setEvent($event);
            $eventRegistration->setRegistrationDate(new \DateTime('now'));
            $eventRegistration->setAdherent($adherent);
            $eventRegistration->setSleepingType($event->getSleepingTypes()[0]);

            $em->persist($eventRegistration);
            $em->flush();

            return $this->redirect($this->generateUrl('event_registration_pay', array(
                    'event_registration_id' => $eventRegistration->getId(),
                )));

        }

        return $this->render('event/registration.html.twig', array(
            'event' => $event,
            'event_registration' => $eventRegistration,
            'form' => $form->createView(),
            'enable_modify' => false,
        ));
    }

    /**
     * Pay for an event.
     *
     * @Route("/registration/{event_registration_id}/pay", name="event_registration_pay",
     *         requirements={"event_registration_id": "\d+"})
     * @ParamConverter("eventRegistration", class="AppBundle:Event\EventAdherentRegistration",
     *                 options={"id"="event_registration_id"})
     */
    public function registrationPayAction(Request $request, EventAdherentRegistration $eventRegistration)
    {
        $event = $eventRegistration->getEvent();
        // $this->denyAccessUnlessGranted('event-register', $event, 'Vous ne disposez pas des droits nécessaires pour vous inscrire.');

        // If it has already payed, redirect to show
        if ($eventRegistration->isPaid()) {
            return $this->redirect($this->generateUrl('event_registration_show', array(
                'event_id' => $event->getId(),
                'event_reg_id' => $eventRegistration->getId()
            )));
        }

        $adherent = $this->getUser()->getProfile();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new EventRegistrationPayType(), $eventRegistration, array(
            'action' => $this->generateUrl('event_registration_pay', array(
                'event_registration_id' => $eventRegistration->getId()
            )),
            'method' => 'POST',
        ));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $eventRegistration = $form->getData();

            // $eventRegistration->setPriceScale($eventRegistration->getCost());

            $em->persist($eventRegistration);
            $em->flush();

            $message = \Swift_Message::newInstance()
                ->setFrom(array('remue-meninges@lepartidegauche.fr' => 'Remues Méninges 2015'))
                ->setSubject('Inscription Remues Méninges 2015')
                ->setTo($this->getUser()->getEmail())
                ->setBody(
                    $this->renderView(
                        'mail/event_register.txt.twig',
                        array('email' => $this->getUser()->getEmail())
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
            'form' => $form->createView(),
            'enable_modify' => true,
        ));
    }

    /**
     * _partial controller that list active event
     */
    public function fragmentListAction()
    {
        $events = $this->getDoctrine()->getManager()
                    ->getRepository('AppBundle:Event\Event')
                    ->findOpenedAtDate(date_create('now'));
        return $this->render('event/_listEvents.twig.html', array(
            'events' => $events,
        ));
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
