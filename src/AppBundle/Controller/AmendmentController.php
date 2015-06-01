<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Text\Amendment;
use AppBundle\Form\Text\AmendmentType;
use AppBundle\Entity\Organ\Organ;
use AppBundle\Entity\Text\TextGroup;
use AppBundle\TextGroupOrganPair;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
     * @param Request   $request
     * @param TextGroup $textGroup
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/envoyer/{text_group_id}/organ/{organ_id}", requirements={"text_group_id" = "\d+", "organ_id" = "\d+"}, name="amendment_submit")
     * @ParamConverter("textGroup", class="AppBundle:Text\TextGroup", options={"id" = "text_group_id"})
     * @ParamConverter("organ", class="AppBundle:Organ\Organ", options={"id" = "organ_id"})
     */
    public function submitAction(Request $request, TextGroup $textGroup, Organ $organ)
    {
        $this->denyAccessUnlessGranted('report_amend', new TextGroupOrganPair($textGroup, $organ), $this->getUser());

        $formAmendment = $this->createForm(
            new AmendmentType(),
            new Amendment($this->getUser()),
            array('text_group_id' => $textGroup->getId())
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
                    array('text_group_id' => $textGroup->getId(), 'organ_id' => $organ->getId())
                ));
            }
        }

        return $this->render('amendment/submit.html.twig', array(
            'form' => isset($displayedForm) ? $displayedForm->createView() : $formAmendment->createView(),
        ));
    }
}
