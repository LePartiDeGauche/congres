<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Election\Election;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
     * @Route("/envoyer/{election_id}/{organ_id}, name="election_report")
     * @ParamConverter("election", class="AppBundle:Election\Election", options={"id" = "election_id"})
     * @ParamConverter("organ", class="AppBundle:Organ\Organ", options={"id" = "organ_id"})
     * @ParamConverter("result", class="AppBundle:Election\Election", options={"id" = "organ_id"})
     *
     *
    public function submitAction(Request $request, Election $election, Organ $organ)
    {
        $this->denyAccessUnlessGranted('report_election', $this->getUser());

        $formElection = $this->createForm(
            new ElectionType(),
            new Election($this->getUser()),
            array('election_id' => $election->getId())
        );

        $formElection->handleRequest($request);
        if ($formElection->isSubmitted()) {
            $formElection->getData()->setElectionResponsable($this->getUser());

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

                return $this->redirect($this->generateUrl('election_report',
                    array('election_id' => $electionGroup->getId(), 'organ_id' => $organ->getId())
                ));
            }
        }

        return $this->render('election/submit.html.twig', array(
            'form' => isset($displayedForm) ? $displayedForm->createView() : $formElection->createView(),
        ));
    }
*/

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