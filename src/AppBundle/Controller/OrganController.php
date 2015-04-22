<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use AppBundle\Entity\Organ\Organ;

/**
 * Organ\Organ controller.
 *
 * @Route("/organ")
 */
class OrganController extends Controller
{

    /**
     * Lists all Organ\Organ public entities.
     *
     * @Route("/", name="organ_list")
     * @Method("GET")
     * @Template("organ/index.html.twig")
     */
    public function indexAction()
    {
        throw \AccessDeniedException();

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Organ\Organ')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Lists all Organ\Organ of an adherent.
     *
     * @Route("/user", name="organ_adherent_list")
     * @Method("GET")
     * @Template("organ/organ_adherent_list.html.twig")
     */
    public function adherentListAction()
    {
        $em = $this->getDoctrine()->getManager();
        $adherent = $this->getUser()->getProfile();

        $entities = $em->getRepository('AppBundle:Organ\Organ')->getOrganByAdherent($adherent);

        return array(
            'adherent' => $adherent,
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Organ\Organ entity.
     *
     * @Route("/{organ_id}", name="organ_show")
     * @Method("GET")
     * @Template("organ/show.html.twig")
     * @ParamConverter("organ", class="AppBundle:Organ\Organ", options={"id" = "organ_id"})
     */
    public function showAction(Organ $organ)
    {
        $em = $this->getDoctrine()->getManager();
        $adherent = $this->getUser()->getProfile();

        if (!$em->getRepository('AppBundle:Organ\Organ')->isMember($organ, $adherent) ) {
            throw \AccessDeniedException();
        }

        return array(
            'entity'      => $organ,
        );
    }
}
