<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use AppBundle\Entity\Event\Event;
use AppBundle\Form\Event\EventType;

/**
 * Event\Event controller.
 *
 * @Route("/event")
 */
class EventController extends Controller
{

    /**
     * Register to a event
     *
     * @Route("/{event_id}/registration/create", name="event_registration_create")
     * @ParamConverter("event_id", class="AppBundle:Event\Event", options={"id" = "event_id"})
     *
     */
    public function registerAction(Request $request, Event $event)
    {
        $eventRegistration = new EventAdherentRegistration($this->getUser()->getProfile());
        $form = $this->createRegistrationCreateForm($eventRegistration, $event);

        $form->handleRequest($request);

        if ($form->isValid())
        {
            $eventRegistration = $form->getData();
            $eventRegistration->setEvent($event);
            $this->getDoctrine()->getManager()->persist($eventRegistration);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('event_registration_show', array('event_id' => $event->getId(), 'event_reg_id' => $eventRegistration->getId())));
        }

        return $this->render("event_registration_create", array(
            'event'      => $event,
            'event_registration'      => $eventRegistration,
            'form'  => $form->createView()))
        ;
    }

    /**
     * Finds and displays a Event\EventAdherentRegistration entity.
     *
     * @Route("{event_id}/registration/{event_reg_id}", name="event_registration_show")
     * @Method("GET")
     * @ParamConverter("event_id", class="AppBundle:Event\Event", options={"id" = "event_id"})
     * @ParamConverter("event_reg_id", class="AppBundle:Event\EventAdherentRegistration", options={"id" = "event_reg_id"})
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
     * Lists all Event\Event entities.
     *
     * @Route("/", name="event")
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
     * Finds and displays a Event\Event entity.
     *
     * @Route("/{id}", name="event_show")
     * @Method("GET")
     * @Template("event/show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Event\Event')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Event\Event entity.');
        }

        return array(
            'entity'      => $entity,
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
