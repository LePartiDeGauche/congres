<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Adherent;
use AppBundle\Entity\Event\Bedroom;
use AppBundle\Entity\Event\BedroomBooking;
use AppBundle\Entity\Event\Booking;
use AppBundle\Entity\Event\Event;
use AppBundle\Entity\Event\EventAdherentRegistration;
use AppBundle\Form\Event\BookingType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * Sleeping\Sleeping controller.
 *
 * @Route("/sleeping")
 */
class SleepingController extends Controller
{
    /**
     * Lists bedrooms available.
     *
     * @Route("/liste", name="sleeping_list")
     *
     * @Method("GET")
     *
     */
    public function sleepingListAction()
    {
        $doctrine = $this->getDoctrine();
        $bedroomRepository = $doctrine->getRepository('AppBundle:Event\Bedroom');
        $bookingRepository = $doctrine->getRepository('AppBundle:Event\Booking');

        $bedrooms = $bedroomRepository->findAll();

        $bookings = [];
        foreach ($bedrooms as $bedroom) {
            $currentDate = clone $bedroom->getDateStartAvailability();


            $duration = $bedroom->getDateStopAvailability()->diff($bedroom->getDateStartAvailability(), true)->days;
            for ($i = 0; $i < $duration; $i++) {

               $bookings[$currentDate->format('Y-m-d')][$bedroom->getId()] = $bookingRepository->findFor($bedroom, $currentDate);

                $currentDate->add(new \DateInterval('P1D'));
            }
        }

        ksort($bookings);

        return $this->render('event/bedroom_list.html.twig', [
            'bedrooms' => $bedrooms,
            'bookings' => $bookings,
        ]);
    }

    /**
     *
     * @param Request  $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/inscription/{id}/{date}", name="sleeping_inscription")
     */
    public function submitAction(Request $request, Bedroom $bedroom, \DateTime $date)
    {
        $adherent = $this->getUser()->getProfile();
        $manager = $this->getDoctrine()->getManager();

        $booking = new Booking();
        $booking->setBedroom($bedroom);
        $booking->setDate($date);
        $booking->setAdherent($adherent);

        $this->denyAccessUnlessGranted('SLEEPING_REPORT', $booking);

        $formSleeping = $this->createForm(new BookingType());
        $formSleeping->setData(array('date'=> $date, 'duration'=>1));
        $formSleeping->handleRequest($request);


        if ($formSleeping->isSubmitted()) {

            $data = $formSleeping->getData();
            $duration = $data['duration'];
            $date = clone $data['date'];

            // ///// A modifier selon le prix de la chambre par nuit
            $price = 60;

            for($i=0; $i < $duration; $i++){
                $booking = new Booking();
                $booking->setAdherent($adherent);
                $booking->setDate($date);
                $booking->setBedroom($bedroom);
                $booking->setPrice($price);

                $manager->persist($booking);

                $manager->flush();
                $date->add(new \DateInterval("P1D"));
            }

            $paiement = $this->get('session')->get('paiement');
            $event = $bedroom->getRoomType()->getSleepingSite()->getEvent();
            $eventRegistration = $this->getDoctrine()
                ->getRepository('AppBundle:Event\EventAdherentRegistration')
                ->findOneBy(array('adherent' => $adherent, 'event' => $event));

            if ($paiement == EventAdherentRegistration::PAYMENT_MODE_ONLINE) {

                $priceComplete = $price * $duration;

                $totalPrice = $eventRegistration->getCost()->getCost()+$priceComplete;
                $eventPayment = $this->createPayment($adherent, $event, $eventRegistration, $totalPrice);

                $manager->persist($eventPayment);
                $manager->flush();

                return $this->redirect($this->generateUrl('payment_pay',
                    array('id' => $eventPayment->getId())));
            } else {
                return $this->redirect($this->generateUrl('event_registration_show',
                    array('event_id' => $event->getId(), 'event_reg_id' => $eventRegistration->getId())));
            }

        }
        return $this->render('event/bedroom_submit.html.twig', array(
            'form' => $formSleeping->createView(),
        ));
    }

    /**
     * @param Adherent $adherent
     * @param Event $event
     * @param EventAdherentRegistration $eventRegistration
     * @param $amount
     * @return EventPayment
     */
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

    /**
     * @param $adherent
     * @return object
     */
    public function bedroomByAdherentAction(Adherent $adherent)
    {
        $booking = $this->getDoctrine()->getRepository('AppBundle:Event\Booking')->findOneBy(['adherent' => $adherent]);

        return $this->render('admin/bedroom_by_adherent.html.twig', ['booking' => $booking]);
    }

    /**
     * @param Bedroom $bedroom
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function bookingsByBedroomAction(Bedroom $bedroom)
    {
        $bookings = $this->getDoctrine()->getRepository('AppBundle:Event\Booking')->findBy(['bedroom' => $bedroom]);
        return $this->render('admin/bookings_by_bedroom.html.twig', ['bookings' => $bookings, 'nbr' => count($bookings)]);
    }
}
