<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Text\Amendment;
use AppBundle\Form\Text\AmendmentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Text\Amendment controller.
 *
 * @Route("/amendements")
 */
class AmendmentController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/envoyer", name="amendment_submit")
     */
    public function submitAction(Request $request)
    {
        $formAmendment = $this->createForm(new AmendmentType(), new Amendment($this->getUser()));

        $formAmendment->handleRequest($request);
        if ($formAmendment->isSubmitted()) {
            $formAmendment->getData()->setAuthor($this->getUser());

            if ($formAmendment->isValid()) {
                $manager = $this->getDoctrine()->getManager();

                $manager->persist($formAmendment->getData());
                $manager->flush();

                return $this->redirect($this->generateUrl('amendment_submit'));
            }
        }

        return $this->render('amendment/submit.html.twig', array(
            'form' => isset($displayedForm) ? $displayedForm->createView() : $formAmendment->createView(),
        ));
    }
}
