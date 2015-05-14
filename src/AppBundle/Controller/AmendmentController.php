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
     * @Route("/envoyer/{text_group_id}", requirements={"text_group_id" = "\d+"}, name="amendment_submit")
     */
    public function submitAction(Request $request)
    {
        $formAmendment = $this->createForm(
            new AmendmentType(),
            new Amendment($this->getUser()),
            array('text_group_id' => $request->get('text_group_id'))
        );

        $formAmendment->handleRequest($request);
        if ($formAmendment->isSubmitted()) {
            $formAmendment->getData()->setAuthor($this->getUser());

            if ($formAmendment->isValid()) {
                $manager = $this->getDoctrine()->getManager();

                $manager->persist($formAmendment->getData());
                $manager->flush();

                $this
                    ->get('session')
                    ->getFlashBag()
                    ->add(
                        'success',
                        'Amendement bien enregistré. Remplissez à nouveau ce formulaire pour en proposer un autre.'
                    )
                ;

                return $this->redirect($this->generateUrl('amendment_submit', 
                    array('text_group_id' => $request->get('text_group_id'))));
            }
        }

        return $this->render('amendment/submit.html.twig', array(
            'form' => isset($displayedForm) ? $displayedForm->createView() : $formAmendment->createView(),
        ));
    }
}
