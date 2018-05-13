<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Election\Election;
use AppBundle\Entity\Election\MaleElectionResult;
use AppBundle\Entity\Election\FemaleElectionResult;
use AppBundle\Form\Election\ElectionType;
use AppBundle\Form\Election\ElectionResultType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
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
     * @param Request  $request
     * @param Election $election
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/rapporter-resultat/{id}", name="election_report")
     * @Security("is_granted('ELECTION_REPORT', election)")
     */
    public function submitAction(Request $request, Election $election)
    {
        $election->setResponsable($this->getUser()->getProfile());
        $max = ceil($election->getNumberOfElected() / 2);
        for ($i=0; $i < $max; $i++) {
            $election->addMaleElectionResult(new MaleElectionResult());
            $election->addFemaleElectionResult(new FemaleElectionResult());
        }

        $formElection = $this->createForm(new ElectionType(), $election);

        $formElection->handleRequest($request);
        if ($formElection->isSubmitted()) {
            $formElection->getData()->setStatus(Election::STATUS_CLOSED);

            if ($formElection->isValid()) {
                $manager = $this->getDoctrine()->getManager();

                $election = $formElection->getData();
                foreach ($election->getMaleElectionResults() as $maleResult) {
                    if ($maleResult->getElected() == null || $maleResult->getNumberOfVote() == null) {
                        $election->removeMaleElectionResult($maleResult);
                    }
                }
                foreach ($election->getFemaleElectionResults() as $femaleResult) {
                    if ($femaleResult->getElected() == null || $femaleResult->getNumberOfVote() == null) {
                        $election->removeFemaleElectionResult($femaleResult);
                    }
                }

                $manager->persist($election);
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
            'form' => $formElection->createView(),
            'election' => $election,
        ));
    }

    /**
     * _partial controller that list active amendment process
     */
    public function fragmentListAction()
    {
        $elections = $this->getDoctrine()->getManager()
                           ->getRepository('AppBundle:Election\Election')
                           ->findByStatus(Election::STATUS_OPEN);
        return $this->render('election/_list.html.twig', array(
            'elections' => $elections,
        ));
    }


    /**
     * @Route("/liste", name="election_list")
     */
    public function listAction()
    {
        $list = $this->getDoctrine()
                     ->getRepository('AppBundle:Election\Election')
                     ->findByStatus(Election::STATUS_OPEN);
        return $this->render('election/list.html.twig', array(
            'electionList' => $list,
        ));
    }
}
