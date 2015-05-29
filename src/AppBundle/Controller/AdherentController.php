<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Adherent controller.
 *
 * @Route("/adherents")
 */
class AdherentController extends Controller
{
    /**
     * @Route("/mon-compte/profil", name="adherent_profile")
     */
    public function profileAction()
    {
        return $this->render('adherent/profile.html.twig');
    }

    /**
     * Search adherents.
     *
     * @Route("/search_adherent/{typedText}", name="search_adherent")
     * @Method({"GET"})
     *
     * @param $typedText
     *
     * @return JsonResponse
     */
    public function searchAdherentAction($typedText = '')
    {
        return new JsonResponse($this->getDoctrine()->getRepository('AppBundle:Adherent')->findAdherentsByTypedText($typedText));
    }
}
