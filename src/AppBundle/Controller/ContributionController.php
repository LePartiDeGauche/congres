<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Congres\GeneralContribution;
use AppBundle\Entity\Congres\ThematicContribution;
use AppBundle\Form\Type\NewCongresContributionType;

/**
 * @Route("/contribution")
 */
class ContributionController extends Controller
{
    /**
     * @Route("/soumettre", name="contribution_submit")
     */
    public function submitAction(Request $request)
    {
        /* We don't know if we are going to create a PlateformContribution or a
         * Thematic contribution. So we create two identical forms (except for
         * the underlying object) which will both handle request. We display
         * arbitrarily one of those, both are handled, and only one is processed
         * depending of the type of contribution chosen.
         */
        $generalContrib = new GeneralContribution();
        $thematicContrib = new ThematicContribution();
        $formGeneral = $this->createForm(new NewCongresContributionType(), $generalContrib);
        $formThematic = $this->createForm(new NewCongresContributionType(), $thematicContrib);

        $formGeneral->handleRequest($request);
        $formThematic->handleRequest($request);
        $displayedForm = $formGeneral; // by default

        if ($formGeneral->isSubmitted() || $formThematic->isSubmitted()) {
            $type = $formGeneral->get('type')->getData();
            if ('generale' === $type) {
                $displayedForm = $formGeneral;

                if ($formGeneral->isValid()) {
                    // do stuff
                }
            } elseif ('thematique' === $type) {
                $displayedForm = $formThematic;
                if ($formThematic->isValid()) {
                    // do stuff
                }
            }
        }

        return $this->render('contribution/submit.html.twig', array(
            'form' => $displayedForm->createView(),
        ));
    }
}
