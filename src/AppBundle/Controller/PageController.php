<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Page;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


/**
 * Pages controller.
 *
 * @Route("/page")
 * @author Clément Talleu <clement@les-tilleuls.coop>
 */
class PageController extends Controller {

    /**
     * Show page.
     *
     * @Route("/{id}", name="page_show")
     *
     * @Method("GET")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function pageShowAction($id) {
        return $this->render('page/page_show.html.twig', array(
            'pageShow' => $this->getDoctrine()->getRepository('AppBundle:Page')->findBy(['id' => $id]),
        ));
    }

}
