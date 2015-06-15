<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Event\Bedroom;
use AppBundle\Entity\Event\BedroomBooking;
use AppBundle\Entity\Event\BedroomBookingRepository;
use AppBundle\Entity\Event\Booking;
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
     *
     */
    public function submitAction(Request $request, Bedroom $bedroom, \DateTime $date)
    {

        $formSleeping = $this->createForm(new BookingType());
        $formSleeping->setData(array('date'=> $date, 'duration'=>1));
        $formSleeping->handleRequest($request);


        if ($formSleeping->isSubmitted()) {

            $data = $formSleeping->getData();
            $duration = $data['duration'];
            $date = clone $data['date'];
            $adherent = $this->getUser()->getProfile();

            for($i=0; $i < $duration; $i++){
                $booking = new Booking();
                $booking->setAdherent($adherent);
                $booking->setDate($date);
                $booking->setBedroom($bedroom);

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($booking);
                $manager->flush();

                $date->add(new \DateInterval("P1D"));
            }

            return $this->redirect($this->generateUrl('sleeping_list'));
        }




        return $this->render('event/bedroom_submit.html.twig', array(
            'form' => $formSleeping->createView(),
        ));



    }
}