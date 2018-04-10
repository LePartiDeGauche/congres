<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Process\AmendmentProcess;
use AppBundle\Entity\Text\AmendmentDeposit;
use AppBundle\Entity\Text\AmendmentItem;
use AppBundle\Form\Text\AmendmentDepositType;
use AppBundle\Form\Text\AmendmentDepositValidateType;
use AppBundle\Form\Text\AmendmentItemType;

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
     * @Route("/amendment/{id}/deposit/create", requirements={"id" = "\d+"}, name="amendment_deposit_create")
     */
    public function createAmendmentDepositAction(AmendmentProcess $amendmentProcess, Request $request)
    {
        $this->denyAccessUnlessGranted('report_amend', $amendmentProcess, $this->getUser());

        $adherent = $this->getUser()->getProfile();
        $amendmentDeposit = $this->getDoctrine()
            ->getRepository('AppBundle:Text\AmendmentDeposit')
            ->findOneBy(array('depositor' => $adherent, 'amendmentProcess' => $amendmentProcess));

        if ($amendmentDeposit && $amendmentDeposit->getIsValidated() == false) {
            return $this->redirect($this->generateUrl('amendment_deposit_edit', array(
                'amendment_process_id' => $amendmentProcess->getId(),
                'amendment_deposit_id' => $amendmentDeposit->getId()
            )));
        }

        // No amendment deposit found, then process
        $amendmentDeposit = new AmendmentDeposit();
        $amendmentDeposit->setDepositor($this->getUser()->getProfile());
        $amendmentDeposit->setMandatary($this->getUser()->getProfile());
        $amendmentProcess->addAmendmentDeposit($amendmentDeposit);

        $form = $this->createForm(
            new AmendmentDepositType(),
            $amendmentDeposit,
            array('em' => $this->getDoctrine()->getManager())
        );

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $amendmentDeposit = $form->getData();
                $amendmentDeposit->setDepositor($this->getUser()->getProfile());

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($amendmentDeposit);
                $manager->flush();

                $this
                    ->get('session')
                    ->getFlashBag()
                    ->add(
                        'success',
                        'Dépôt d\'amendement bien enregistré. Vous pouvez maintenant ajouter des amendements.'
                    )
                ;

                return $this->redirect($this->generateUrl('amendment_deposit_edit', array(
                    'amendment_process_id' => $amendmentProcess->getId(),
                    'amendment_deposit_id' => $amendmentDeposit->getId()
                )));
            }
        }

        return $this->render('process/amendment_deposit_create.html.twig', array(
            'form' => $form->createView(),
            'amendmentProcess' => $amendmentProcess,
        ));
    }

    /**
     * @param AmendmentProcess $amendmentProcess
     * @param AmendmentDeposit $amendmentDeposit
     *
     * @Route("/amendment/{amendment_process_id}/deposit/{amendment_deposit_id}/edit",
     *         name="amendment_deposit_edit",
     *         requirements={
     *             "amendment_process_id": "\d+",
     *             "amendment_deposit_id": "\d+"
     *  })
     *
     * @ParamConverter("amendmentProcess", class="AppBundle:Process\AmendmentProcess", options={"id" = "amendment_process_id"})
     * @ParamConverter("amendmentDeposit", class="AppBundle:Text\AmendmentDeposit", options={"id" = "amendment_deposit_id"})
     *
     * @Template("process/amendment_deposit_edit.html.twig")
     */
    public function editAmendmentDepositAction(AmendmentProcess $amendmentProcess, AmendmentDeposit $amendmentDeposit, Request $request)
    {
        $this->denyAccessUnlessGranted('report_amend', $amendmentProcess, $this->getUser());

        // Checks if amendment deposit is validated
        // if ($amendmentDeposit->isValidated()) {
        //     return $this->redirect($this->generateUrl('amendement_deposit_show', array(
        //         'amendment_process_id' => $amendmentProcess->getId(),
        //         'amendment_deposit_id' => $amendmentDeposit->getId()
        //     )));
        // }

        // Checks if amendmentitem already exists
        //
        // else
        $amendmentItem = new AmendmentItem();
        $amendmentItem->setAmendmentDeposit($amendmentDeposit);

        $form = $this->createForm(
            new AmendmentItemType(),
            $amendmentItem
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $amendmentItem = $form->getData();

            $repository = $this->getDoctrine()->getRepository('AppBundle:Text\AmendmentItem');

            $amendmentItem->setReference(
                sprintf('%s/%s/%s/%s',
                    substr($amendmentItem->getText(), 0, 1),
                    $amendmentItem->getAmendmentDeposit()->getOrigin(),
                    $amendmentItem->getAmendmentDeposit()->getDepositor()->getDepartementNumber(),
                    $repository->getCountByText($amendmentItem->getText()) + 1
                )
            );

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($amendmentItem);
            $manager->flush();

            $this
                ->get('session')
                ->getFlashBag()
                ->add(
                    'success',
                    'Amendement ajouté. Vous pouvez maintenant em ajouter d\'autres.'
                )
            ;

            return $this->redirect($this->generateUrl('amendment_deposit_edit', array(
                'amendment_process_id' => $amendmentProcess->getId(),
                'amendment_deposit_id' => $amendmentDeposit->getId()
            )));
        }

        return array(
            'form' => $form->createView(),
            'amendmentDeposit' => $amendmentDeposit,
            'amendmentProcess' => $amendmentProcess,
        );
    }

    /**
     * @param AmendmentProcess $amendmentProcess
     * @param AmendmentDeposit $amendmentDeposit
     *
     * @Route("/amendment/{amendment_process_id}/deposit/{amendment_deposit_id}/validate",
     *         name="amendment_deposit_validate",
     *         requirements={
     *             "amendment_process_id": "\d+",
     *             "amendment_deposit_id": "\d+"
     *  })
     *
     * @ParamConverter("amendmentProcess", class="AppBundle:Process\AmendmentProcess", options={"id" = "amendment_process_id"})
     * @ParamConverter("amendmentDeposit", class="AppBundle:Text\AmendmentDeposit", options={"id" = "amendment_deposit_id"})
     *
     * @Template("process/amendment_deposit_validate.html.twig")
     */
    public function validateAmendmentDepositAction(AmendmentProcess $amendmentProcess, AmendmentDeposit $amendmentDeposit, Request $request)
    {
        $this->denyAccessUnlessGranted('report_amend', $amendmentProcess, $this->getUser());

        $form = $this->createForm(
            new AmendmentDepositValidateType(),
            $amendmentDeposit
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $amendmentDeposit = $form->getData();
            $amendmentDeposit->setIsValidated(true);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($amendmentDeposit);
            $manager->flush();

            $this
                ->get('session')
                ->getFlashBag()
                ->add(
                    'success',
                    'Dépôt d\'amendements réussi. Vous pouvez maintenant déposer une nouvelle série d\'amendements.'
                )
            ;

            return $this->redirect($this->generateUrl('homepage'));
        }

        return array(
            'form' => $form->createView(),
            'amendmentDeposit' => $amendmentDeposit,
            'amendmentProcess' => $amendmentProcess,
        );
    }
}
