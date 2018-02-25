<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

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
     * @Route("/search", name="search_adherent")
     * @Method({"GET"})
     *
     * @param $typedText
     *
     * @return JsonResponse
     */
    public function searchAdherentAction(Request $request)
    {
        $typedText = $request->query->get('term');
        if (!isset($typedText)) {
            return JsonResponse(array());
        }

        $adherents = $this->getDoctrine()
                          ->getRepository('AppBundle:Adherent')
                          ->findAdherentsByTypedText($typedText);

        $results = array();
        foreach ($adherents as $adherent) {
            $results[] = array(
                'id' => $adherent['id'],
                'name' => $adherent['firstname'],
                'label' => sprintf('%s %s <%s>', $adherent['firstname'],
                                                 $adherent['lastname'],
                                                 $adherent['email'])
            );
        }
        return new JsonResponse($results);
    }

    /**
     * Get adherent by its id
     *
     * @Route("/get/{id}", name="get_adherent")
     * @Method({"GET"})
     *
     * @param $id
     *
     * @return JsonResponse
     */
    public function getAdherentAction($id)
    {
        $adherent = $this->getDoctrine()
             ->getRepository('AppBundle:Adherent')
             ->find($id);
        if (!$adherent) {
            return new Response();
        }
        return new Response(
            sprintf('%s %s <%s>', $adherent->getFirstname(),
                                  $adherent->getLastname(),
                                  $adherent->getEmail())
        );
    }
}
