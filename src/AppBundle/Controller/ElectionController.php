<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Election\Election;
use AppBundle\Entity\Organ\Organ;
use AppBundle\Form\Election\ElectionType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * Election\Election controller.
 *
 * @Route("/elections")
 */
class ElectionController extends Controller
{

    /**
     * @param Request $request
     * @param Election $election
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/rapporter-resultat/{id}", name="election_report")
     */
    public function submitAction(Request $request, Election $election)
    {
        // security   --->   $this->denyAccessUnlessGranted('report_election', $this->getUser());


        $formElection = $this->createForm(
            new ElectionType(), $election
        );

        $formElection->handleRequest($request);
        if ($formElection->isSubmitted()) {
            $formElection->getData()->setStatus(Election::STATUS_CLOSED);

            if ($formElection->isValid()) {
                $manager = $this->getDoctrine()->getManager();

                $manager->persist($formElection->getData());
                $manager->flush();

                $this
                    ->get('session')
                    ->getFlashBag()
                    ->add(
                        'success',
                        'Résultat bien enregistré.'
                    )
                ;

                return $this->redirect($this->generateUrl('election_list'));
            }
        }

        return $this->render('election/submit.html.twig', array(
            'form' => isset($displayedForm) ? $displayedForm->createView() : $formElection->createView(),
        ));
    }


    /**
     * @Route("/liste", name="election_list")
     */
    public function listAction(Request $request)
    {

        $electionRepository = $this->getDoctrine()->getRepository('AppBundle:Election\Election');

        $electionList = $electionRepository->findAll();

        return $this->render('election/list.html.twig', array(
            'electionList' => $electionList,
        ));
    }
}