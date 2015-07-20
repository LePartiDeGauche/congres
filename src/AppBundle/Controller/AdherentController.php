<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\AdherentType;
use AppBundle\Entity\Adherent;

/**
 * Adherent controller.
 *
 * @Route("/adherents")
 */
class AdherentController extends Controller
{
    /**
     * Register a non adherent
     * @Route("/register", name="non_adherent_register")
     */
    public function registerAction(Request $request)
    {
        //$this->denyAccessUnlessGranted('report_amend', new TextGroupOrganPair($textGroup, $organ), $this->getUser());

        $profile = new Adherent();

        $form = $this->createForm(
            new AdherentType(),
            $profile
        );

        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            if ($form->isValid()) {

                $profile = $form->getData();
                $profile->setEmail($this->getUser()->getEmail());
                $profile->setUser($this->getUser());
                $profile->setStatus(Adherent::STATUS_SYMPATHISANT);

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($profile);
                $manager->flush();

                $this->getUser()->setEnabled(true);
                $this->getUser()->setProfile($profile);
                $this->userManager = $this->container->get('fos_user.user_manager');
                $this->userManager->updateUser($this->getUser());

                return $this->redirect($this->generateUrl('homepage'));
            }
        }

        return $this->render('adherent/non_adherent_register.html.twig', array(
            'form' => $form->createView(),
        ));
    }

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
