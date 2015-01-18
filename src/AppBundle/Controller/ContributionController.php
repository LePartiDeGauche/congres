<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Congres\Contribution;
use AppBundle\Entity\Congres\GeneralContribution;
use AppBundle\Entity\Congres\ThematicContribution;
use AppBundle\Form\Type\NewCongresContributionType;
use AppBundle\RouteString;

/**
 * @Route("/contribution")
 */
class ContributionController extends Controller
{
    /**
     * @Route("/envoyer", name="contribution_submit")
     */
    public function submitAction(Request $request)
    {
        $this->denyAccessUnlessGranted('view', new RouteString($request->get('_route')));

        /* We don't know if we are going to create a PlateformContribution or a
         * Thematic contribution. So we create two identical forms (except for
         * the underlying object) which will both handle request. We display
         * arbitrarily one of those, both are handled, and only one is processed
         * depending of the type of contribution chosen.
         */
        $formGeneral = $this->createForm(new NewCongresContributionType(), new GeneralContribution($this->getUser()));
        $formThematic = $this->createForm(new NewCongresContributionType(), new ThematicContribution($this->getUser()));

        $formGeneral->handleRequest($request);
        $formThematic->handleRequest($request);

        if ($formGeneral->isSubmitted() || $formThematic->isSubmitted()) {
            $type = $formGeneral->get('type')->getData();

            if ('generale' === $type) {
                $displayedForm = $formGeneral;
            } elseif ('thematique' === $type) {
                $displayedForm = $formThematic;
            }

            if ($displayedForm->isValid()) {
                $this->getDoctrine()->getManager()->persist($displayedForm->getData());
                $this->getDoctrine()->getManager()->flush();

                return $this->redirect($this->generateUrl('contribution_my_submissions'));
            }
        }

        return $this->render('contribution/submit.html.twig', array(
            'form' => isset($displayedForm) ? $displayedForm->createView() : $formGeneral->createView(),
        ));
    }

    /**
     * @Route("/mes-contributions", name="contribution_my_submissions")
     */
    public function mySubmissionsAction()
    {
        $repo = $this->getDoctrine()->getRepository('AppBundle:Congres\GeneralContribution');
        $generalContrib = $repo->findOneByAuthor($this->getUser());

        $repo = $this->getDoctrine()->getRepository('AppBundle:Congres\ThematicContribution');
        $thematicContribs = $repo->findByAuthor($this->getUser());

        return $this->render('contribution/my_submissions.html.twig', array(
            'generalContrib' => $generalContrib,
            'thematicContribs' => $thematicContribs,
        ));
    }

    /**
     * @Route("/lire/{id}", name="contribution_view")
     */
    public function viewAction(Contribution $contrib)
    {
        $this->denyAccessUnlessGranted('view', $contrib);
        $isVoteAllowed =
            $this->get('security.authorization_checker')
            ->isGranted('vote', new RouteString('contribution_vote'), $this->getUser());

        switch (get_class($contrib)) {
            case 'AppBundle\Entity\Congres\GeneralContribution':
                $type = 'general';
                $repo  = $this->getDoctrine()->getRepository('AppBundle:Congres\GeneralContribution');
                break;
            case 'AppBundle\Entity\Congres\ThematicContribution':
                $type = 'thematic';
                $repo  = $this->getDoctrine()->getRepository('AppBundle:Congres\ThematicContribution');
                break;
            default:
                return $this->createNotFoundException();
                break;
        }

        $votes = $repo->getVotes($contrib, $this->getUser());

        return $this->render('contribution/view.html.twig', array(
            'contrib' => $contrib,
            'votes' => $votes,
            'type' => $type,
        ));
    }

    /**
     * @Route("/liste", name="contribution_list")
     */
    public function listAction(Request $request)
    {
        $this->denyAccessUnlessGranted('view', new RouteString('contribution_vote'));

        $generalRepo = $this->getDoctrine()->getRepository('AppBundle:Congres\GeneralContribution');
        $generalOpenContribs = $generalRepo->findByStatusWithVotes(Contribution::STATUS_SIGNATURES_OPEN, $this->getUser());
        $generalClosedContribs = $generalRepo->findByStatusWithVotes(Contribution::STATUS_SIGNATURES_CLOSED, $this->getUser());

        $repo = $this->getDoctrine()->getRepository('AppBundle:Congres\ThematicContribution');
        $thematicOpenContribs = $repo->findByStatusWithVotes(Contribution::STATUS_SIGNATURES_OPEN, $this->getUser());
        $thematicClosedContribs = $repo->findByStatusWithVotes(Contribution::STATUS_SIGNATURES_CLOSED, $this->getUser());

        return $this->render('contribution/list.html.twig', array(
                'generalOpenContribs' => $generalOpenContribs,
                'generalClosedContribs' => $generalClosedContribs,
                'thematicOpenContribs' => $thematicOpenContribs,
                'thematicClosedContribs' => $thematicClosedContribs,
            ));
    }

    /**
     * @Route("/voter/{id}", name="contribution_vote")
     */
    public function voteAction(Contribution $contrib, Request $request)
    {
        $this->denyAccessUnlessGranted('view', new RouteString($request->get('_route')));
        $this->denyAccessUnlessGranted('vote', $contrib);

        $form = $this->createFormBuilder()
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            if (is_a($contrib, "AppBundle\Entity\Congres\GeneralContribution")) {
                $contrib_repo = $em->getRepository("AppBundle:Congres\GeneralContribution");
            } else {
                $contrib_repo = $em->getRepository("AppBundle:Congres\ThematicContribution");
            }

            $contrib->addVote($this->getUser());

            if ($contrib_repo->getCNVotesCount($contrib) >= 10 ||
                $contrib_repo->getVotesCount($contrib) >= 50) {
                $contrib->setStatus(Contribution::STATUS_SIGNATURES_CLOSED);
            }

            $em->flush();

            return $this->redirect($this->generateUrl('contribution_list'));
        }

        return $this->render('contribution/vote.html.twig', array(
            'contrib' => $contrib,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/supprimer/{id}", name="contribution_delete")
     */
    public function deleteAction(Contribution $contrib, Request $request)
    {
        $this->denyAccessUnlessGranted('view', new RouteString('contribution_submit'));
        $this->denyAccessUnlessGranted('delete', $contrib);

        $form = $this->createFormBuilder()
            ->getForm();

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($contrib);
            $em->flush();

            return $this->redirect($this->generateUrl('contribution_my_submissions'));
        }

        return $this->render('contribution/delete.html.twig', array(
            'contrib' => $contrib,
            'form' => $form->createView(),
        ));
    }
}
