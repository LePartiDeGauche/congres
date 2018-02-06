<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Congres\Contribution;
use AppBundle\Entity\Congres\GeneralContribution;
use AppBundle\Entity\Congres\ThematicContribution;
use AppBundle\Entity\Congres\StatuteContribution;
use AppBundle\Form\Type\NewCongresContributionType;

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
        $this->denyAccessUnlessGranted('CALENDAR_contribution_submit');

        /* We don't know if we are going to create a PlateformContribution or a
         * Thematic contribution. So we create two identical forms (except for
         * the underlying object) which will both handle request. We display
         * arbitrarily one of those, both are handled, and only one is processed
         * depending of the type of contribution chosen.
         */
        $formGeneral = $this->createForm(new NewCongresContributionType(), new GeneralContribution($this->getUser()));
        $formThematic = $this->createForm(new NewCongresContributionType(), new ThematicContribution($this->getUser()));
        $formStatute = $this->createForm(new NewCongresContributionType(), new StatuteContribution($this->getUser()));

        $formGeneral->handleRequest($request);
        $formThematic->handleRequest($request);
        $formStatute->handleRequest($request);

        if ($formGeneral->isSubmitted() || $formThematic->isSubmitted() || $formStatute->isSubmitted()) {
            $type = $formGeneral->get('type')->getData();

            if ('generale' === $type) {
                $displayedForm = $formGeneral;
            } elseif ('thematique' === $type) {
                $displayedForm = $formThematic;
            } elseif ('statutaire' === $type) {
                $displayedForm = $formStatute;
            }

            if ($displayedForm->isSubmitted() && $displayedForm->isValid()) {
                $contribution = $displayedForm->getData();

                $deposit_type = $displayedForm->get('deposit_type')->getData();
                if ($deposit_type == Contribution::DEPOSIT_TYPE_COMMISSION) {
                    $contribution->setDepositTypeValue($displayedForm->get('deposit_type_value')->getData());
                } else {
                    $contribution->setDepositTypeValue($deposit_type);
                }

                $this->getDoctrine()->getManager()->persist($displayedForm->getData());
                $this->getDoctrine()->getManager()->flush();

                $this
                    ->get('session')
                    ->getFlashBag()
                    ->add(
                        'warning',
                        'Contribution enregistrée. Le statut de ton adhésion et la longueur en caractère de ta contribution seront contrôlés par la commission des votes.'
                    )
                ;

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

        $repo = $this->getDoctrine()->getRepository('AppBundle:Congres\StatuteContribution');
        $statuteContribs = $repo->findByAuthor($this->getUser());

        return $this->render('contribution/my_submissions.html.twig', array(
            'generalContrib' => $generalContrib,
            'thematicContribs' => $thematicContribs,
            'statuteContribs' => $statuteContribs,
        ));
    }

    /**
     * @Route("/lire/{id}", name="contribution_view")
     */
    public function viewAction(Contribution $contrib)
    {
        $this->denyAccessUnlessGranted('CALENDAR_contribution_read');
        $this->denyAccessUnlessGranted('view', $contrib);

        switch (get_class($contrib)) {
            case 'AppBundle\Entity\Congres\GeneralContribution':
                $type = 'general';
                $repo = $this->getDoctrine()->getRepository('AppBundle:Congres\GeneralContribution');
                break;
            case 'AppBundle\Entity\Congres\ThematicContribution':
                $type = 'thematic';
                $repo = $this->getDoctrine()->getRepository('AppBundle:Congres\ThematicContribution');
                break;
            case 'AppBundle\Entity\Congres\StatuteContribution':
                $type = 'statute';
                $repo = $this->getDoctrine()->getRepository('AppBundle:Congres\StatuteContribution');
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
     * @Route("/", name="contribution_list")
     */
    public function listAction(Request $request)
    {
        $this->denyAccessUnlessGranted('CALENDAR_contribution_read');

        $generalRepo = $this->getDoctrine()->getRepository('AppBundle:Congres\GeneralContribution');
        $generalOpenContribs = $generalRepo->findByStatusWithVotes(Contribution::STATUS_SIGNATURES_OPEN, $this->getUser());
        $generalClosedContribs = $generalRepo->findByStatusWithVotes(Contribution::STATUS_SIGNATURES_CLOSED, $this->getUser());

        $thematicRepo = $this->getDoctrine()->getRepository('AppBundle:Congres\ThematicContribution');
        $thematicOpenContribs = $thematicRepo->findByStatusWithVotes(Contribution::STATUS_SIGNATURES_OPEN, $this->getUser());
        $thematicClosedContribs = $thematicRepo->findByStatusWithVotes(Contribution::STATUS_SIGNATURES_CLOSED, $this->getUser());

        $statuteRepo = $this->getDoctrine()->getRepository('AppBundle:Congres\StatuteContribution');
        $statuteOpenContribs = $statuteRepo->findByStatusWithVotes(Contribution::STATUS_SIGNATURES_OPEN, $this->getUser());
        $statuteClosedContribs = $statuteRepo->findByStatusWithVotes(Contribution::STATUS_SIGNATURES_CLOSED, $this->getUser());

        return $this->render('contribution/list.html.twig', array(
            'generalOpenContribs' => $generalOpenContribs,
            'generalClosedContribs' => $generalClosedContribs,
            'thematicOpenContribs' => $thematicOpenContribs,
            'thematicClosedContribs' => $thematicClosedContribs,
            'statuteOpenContribs' => $statuteOpenContribs,
            'statuteClosedContribs' => $statuteClosedContribs,
        ));
    }

    /**
     * @Route("/valides", name="contribution_list_valid")
     */
    public function listValidAction(Request $request)
    {
        $this->denyAccessUnlessGranted('CALENDAR_contribution_read');

        $generalRepo = $this->getDoctrine()->getRepository('AppBundle:Congres\GeneralContribution');
        $generalClosedContribs = $generalRepo->findByStatus(Contribution::STATUS_SIGNATURES_CLOSED);

        $thematicRepo = $this->getDoctrine()->getRepository('AppBundle:Congres\ThematicContribution');
        $thematicClosedContribs = $thematicRepo->findByStatus(Contribution::STATUS_SIGNATURES_CLOSED);

        $statuteRepo = $this->getDoctrine()->getRepository('AppBundle:Congres\StatuteContribution');
        $statuteClosedContribs = $statuteRepo->findByStatus(Contribution::STATUS_SIGNATURES_CLOSED);

        return $this->render('contribution/listValid.html.twig', array(
            'generalClosedContribs' => $generalClosedContribs,
            'thematicClosedContribs' => $thematicClosedContribs,
            'statuteClosedContribs' => $statuteClosedContribs,
        ));
    }

    /**
     * @Route("/voter/{id}", name="contribution_vote")
     */
    public function voteAction(Contribution $contrib, Request $request)
    {
        $this->denyAccessUnlessGranted('CALENDAR_contribution_vote');
        $this->denyAccessUnlessGranted('vote', $contrib);

        if (is_a($contrib, "AppBundle\Entity\Congres\GeneralContribution")) {
            $type = 'general';
        } elseif (is_a($contrib, "AppBundle\Entity\Congres\ThematicContribution")) {
            $type = 'thematic';
        } else {
            $type = 'statute';
        }

        $form = $this->createFormBuilder()
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            if ($type === 'general') {
                $contrib_repo = $em->getRepository("AppBundle:Congres\GeneralContribution");
            } elseif ($type === 'thematic') {
                $contrib_repo = $em->getRepository("AppBundle:Congres\ThematicContribution");
            } else {
                $contrib_repo = $em->getRepository("AppBundle:Congres\StatuteContribution");
            }

            $contrib->addVote($this->getUser());
            $em->flush();

            return $this->redirect($this->generateUrl('contribution_list'));
        }

        return $this->render('contribution/vote.html.twig', array(
            'contrib' => $contrib,
            'form' => $form->createView(),
            'type' => $type,
        ));
    }

    /**
     * @Route("/supprimer/{id}", name="contribution_delete")
     */
    public function deleteAction(Contribution $contrib, Request $request)
    {
        $this->denyAccessUnlessGranted('CALENDAR_contribution_submit');
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
