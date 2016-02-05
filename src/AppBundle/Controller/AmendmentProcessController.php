<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Process\AmendmentProcess;
use AppBundle\Entity\Text\Amendment;
use AppBundle\Form\Text\AmendmentType;

/**
 * Amendment Process controller.
 *
 * @Route("/process")
 */
class AmendmentProcessController extends Controller
{
    /**
     * _partial controller that list active amendment process
     */
    public function fragmentListAction()
    {
        $processes = $this->getDoctrine()->getManager()
                           ->getRepository('AppBundle:Process\AmendmentProcess')
                           ->findOpenedAtDate(date_create('now'));
        return $this->render('process/_list.html.twig', array(
            'processes' => $processes,
        ));
    }

    /**
     * @param AmendmentProcess $amendmentProcess
     *
     * @Route("/show/{id}", requirements={"id" = "\d+"}, name="process_show")
     */
    public function showAction(AmendmentProcess $amendmentProcess)
    {
        return $this->render('process/show.html.twig', array(
            'amendmentProcess' => $amendmentProcess,
        ));
    }

    /**
     * @param AmendmentProcess $amendmentProcess
     *
     * @Route("/amendment/create/{id}", requirements={"id" = "\d+"}, name="process_amendment_create")
     */
    public function createAmendmentAction(AmendmentProcess $amendmentProcess, Request $request)
    {
        $this->denyAccessUnlessGranted('report_amend', $amendmentProcess, $this->getUser());

        $amendment = new Amendment();
        $amendment->setAuthor($this->getUser()->getProfile());
        $amendmentProcess->addAmendment($amendment);

        $formAmendment = $this->createForm(
            new AmendmentType(),
            $amendment,
            array('em' => $this->getDoctrine()->getManager())
        );


        $formAmendment->handleRequest($request);
        if ($formAmendment->isSubmitted()) {

            if ($formAmendment->isValid()) {
                $formAmendment->getData()->setAuthor($this->getUser()->getProfile());
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

                return $this->redirectToRoute(
                    'process_amendment_create',
                    array('id' => $amendmentProcess->getId())
                );
            }
        }

        return $this->render('process/amendment_create.html.twig', array(
            'form' => $formAmendment->createView(),
        ));
    }
}
