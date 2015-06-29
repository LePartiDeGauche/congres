<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


/**
 * Menus|Pages controller.
 *
 * @Route("/categories")
 * @author Clément Talleu <clement@les-tilleuls.coop>
 */
class CategoryController extends Controller {

    /**
     * Lists  active Category.
     *
     * @Route("/liste/{id}", name="list_category")
     *
     * @Method("GET")
     */
    public function menuCategoryAction() {

        return $this->render('page/category_list.html.twig', array(
            'categoryList' => $this->getDoctrine()->getRepository('AppBundle:Category')->findAll(),
        ));
    }
}
