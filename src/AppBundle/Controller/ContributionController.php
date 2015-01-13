<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Congres\Contribution;
use AppBundle\Entity\Congres\GeneralContribution;
use AppBundle\Entity\Congres\ThematicContribution;
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

        return $this->render('contribution/view.html.twig', array(
            'contrib' => $contrib,
        ));
    }

    /**
     * @Route("/supprimer/{id}", name="contribution_delete")
     */
    public function deleteAction(Contribution $contrib, Request $request)
    {
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
            'form' => $form->createView()
        ));
    }
}
