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
     * Lists  active pages.
     *
     * @Route("/liste/{categoryId}", name="list_page")
     *
     * @Method("GET")
     */
    public function pageListAction($categoryId) {

        return $this->render('page/page_list.html.twig', array(
            'pageList' => $this->getDoctrine()->getRepository('AppBundle:Page')->findActivePageByCategory(['category' => $categoryId]),
        ));
    }

    /**
     * Lists  active pages.
     *
     * @Route("/{pageId}", name="show_page")
     *
     * @Method("GET")
     * @param $pageId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function pageShowAction($pageId) {

        return $this->render('page/page_show.html.twig', array(
            'pageShow' => $this->getDoctrine()->getRepository('AppBundle:Page')->findBy(['id' => $pageId]),
        ));
    }

}
