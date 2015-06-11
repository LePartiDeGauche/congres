<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Event\Booking;
use AppBundle\Form\Event\BookingType;
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
     * @Route("/liste", name="sleeping_list")
     */
    public function sleepingListAction()
    {
        return $this->render('event/bedroom_list.html.twig', array(
            'bedroomList' => $this->getDoctrine()->getRepository('AppBundle:Event\Bedroom')->findAll(),
        ));
    }

    /**
     *
     * @param Request  $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/inscription/{id}", name="sleeping_inscription")
     *
     */
    public function submitAction(Request $request)
    {
        $formSleeping = $this->createForm(new BookingType());

        $formSleeping->handleRequest($request);

        if ($formSleeping->isSubmitted()) {

            $data = $formSleeping->getData();

            $duration = $data['duration'];

            for($i=0; $i<=$duration; $i++){
                new Booking();
            }

            return $this->redirect($this->generateUrl('sleeping_list'));
        }




        return $this->render('event/bedroom_submit.html.twig', array(
            'form' => $formSleeping->createView(),
        ));



    }
}