<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Event\Bedroom;


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
}