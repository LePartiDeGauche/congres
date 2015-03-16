<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use AppBundle\Entity\Event\Event;
use AppBundle\Entity\Event\EventAdherentRegistration;
use AppBundle\Form\Event\EventType;
use AppBundle\Form\Event\EventAdherentRegistrationType;

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
     * @Method("GET")
     * @ParamConverter("event", class="AppBundle:Event\Event", options={"id" = "event_id"})
     * @ParamConverter("eventRegistration", class="AppBundle:Event\EventAdherentRegistration", options={"id" = "event_reg_id"})
     * @Template("event/registration_show.html.twig")
     */
    public function registrationShowAction(Event $event, EventAdherentRegistration $eventRegistration)
    {

        return array(
            'event'      => $event,
            'eventRegistration' => $eventRegistration
        );
    }

    /**
     * Register to a event
     *
     * @Route("/{event_id}/registration/create", name="event_registration_create", requirements={
     *     "event_id": "\d+"
     *     })
     * @ParamConverter("event", class="AppBundle:Event\Event", options={"id" = "event_id"})
     *
     */
    public function registerAction(Request $request, Event $event)
    {
        $adherent = $this->getUser()->getProfile();
        $eventRegistration = new EventAdherentRegistration($this->getUser()->getProfile(), $event);

        $eventRegistration->setAdherent($adherent);
        $form = $this->createRegistrationCreateForm($eventRegistration, $event);

        $form->handleRequest($request);

        if ($form->isValid())
        {
            $eventRegistration = $form->getData();
            $eventRegistration->setEvent($event);
            $eventRegistration->setRegistrationDate(new \DateTime('now'));
            $eventRegistration->setAdherent($this->getUser()->getProfile());

            $this->getDoctrine()->getManager()->persist($eventRegistration);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('event_registration_show', array('event_id' => $event->getId(), 'event_reg_id' => $eventRegistration->getId())));
        }

        return $this->render("event/registration.html.twig", array(
            'event'      => $event,
            'event_registration'      => $eventRegistration,
            'form'  => $form->createView()))
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
            'event'      => $event,
        );
    }

    /**
     * Lists all Event\Event entities.
     *
     * @Route("/list", name="event")
     * @Method("GET")
     * @Template("event/index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Event\Event')->findAll();

        return array(
            'entities' => $entities,
        );
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
}
