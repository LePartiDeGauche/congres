<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Vote\IndividualTextVote;
use AppBundle\Entity\Vote\IndividualOrganTextVote;
use AppBundle\Entity\Vote\IndividualTextVoteAgregation;
use AppBundle\Entity\Vote\ThresholdVoteRule;
use AppBundle\Entity\Text\TextGroup;
use AppBundle\Entity\Text\Text;
use AppBundle\Entity\User;
use AppBundle\Entity\Organ\Organ;
use AppBundle\Form\Text\TextType;
use AppBundle\TextGroupOrganPair;
use AppBundle\Form\Vote\IndividualOrganTextVoteType;

/**
 * Text\Text controller.
 *
 * @Route("/textgroup")
 */
class TextController extends Controller
{
    /**
     * _partial controller that list active textgroups
     */
    public function _listAction()
    {
        $textgroups = $this->getDoctrine()->getManager()
                           ->getRepository('AppBundle:Text\TextGroup')
                           ->findOpenedAtDate(date_create('now'));
        return $this->render('text/_list.html.twig', array(
            'textgroups' => $textgroups,
        ));
    }

    /**
     * Lists all Text\Text entities.
     *
     * @Route("/{group_id}/list", name="text_list")
     *
     * @Method("GET")
     * @ParamConverter("textGroup", class="AppBundle:Text\TextGroup", options={"id" = "group_id"})
     */
    public function indexAction(TextGroup $textGroup)
    {
        $this->denyAccessUnlessGranted('view', $textGroup);
        $author = $this->getUser()->getProfile();

        $em = $this->getDoctrine()->getManager();

        $texts = $em->getRepository('AppBundle:Text\Text')
            ->findTextAndVoteByTextGroup($author, $textGroup);

        $reportOrgans = null;
        if ($textGroup->getVoteType() == TextGroup::VOTETYPE_COLLECTIVE) {
            $reportOrgans = $em->getRepository('AppBundle:Text\TextGroup')
                ->getOrganAdherentCanReportFor($author);
        }

        $textGroupVoteGranted = $this->isGranted('vote', $textGroup);

        $date = new \DateTime('now');

        return $this->render('text/list.html.twig', array(
            'textGroupVoteGranted' => $textGroupVoteGranted,
            'showVotePanel' => ($textGroup->getVoteOpening() < $date && $textGroup->getVoteClosing() > $date),
            'showValidatedPanel' => $textGroup->getVoteOpening() < $date,
            'textGroup' => $textGroup,
            'texts' => $texts,
            'reportOrgans' => $reportOrgans,
        ));
    }

    /**
     * Lists Text\Text entities for author.
     *
     * @Route("/user", name="text_user_list")
     *
     * @Method("GET")
     */
    public function userListAction()
    {
        // FIXME: for now we always display current user info
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $texts = $em->getRepository('AppBundle:Text\Text')->findByAuthor($user->getProfile());

        return $this->render('text/user_list.html.twig', array(
            'texts' => $texts,
            'adherent' => $user->getProfile(),
        ));
    }

    /**
     * Finds and displays a Text\Text entity.
     *
     * @Route("/{group_id}/text/{text_id}", name="text_show")
     *
     * @Method("GET")
     * @ParamConverter("textGroup", class="AppBundle:Text\TextGroup", options={"id" = "group_id"})
     * @ParamConverter("text", class="AppBundle:Text\Text", options={"id" = "text_id"})
     * @Template("text/show.html.twig")
     */
    public function showAction(TextGroup $textGroup, Text $text)
    {
        $this->denyAccessUnlessGranted('view', $textGroup);
        $this->denyAccessUnlessGranted('view', $text);

        return array(
            'textGroup' => $textGroup,
            'text' => $text,
        );
    }

    /**
     * Finds and displays a Text\Text entity.
     *
     * @Route("/{group_id}/create", name="text_create")
     * @ParamConverter("textGroup", class="AppBundle:Text\TextGroup", options={"id" = "group_id"})
     */
    public function newAction(Request $request, TextGroup $textGroup)
    {
        $this->denyAccessUnlessGranted('create_text', $textGroup);

        $text = new Text($this->getUser()->getProfile());
        $form = $this->createCreateForm($text, $textGroup);

        $form->handleRequest($request);

        if ($form->isValid() && $form->getData()->getRawContent() != null) {
            $text = $form->getData();
            $text->setTextGroup($textGroup);
            foreach ($textGroup->getVoteRules() as $voteRule) {
                $itva = new IndividualTextVoteAgregation($text, $textGroup, $voteRule);
                $text->addIndividualVoteAgregation($itva);
                $this->getDoctrine()->getManager()->persist($itva);
            }
            $this->getDoctrine()->getManager()->persist($text);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('text_user_list'));
        }

        return $this->render('text/new.html.twig', array(
            'textGroup' => $textGroup,
            'text' => $text,
            'form' => $form->createView(), )
        );
    }
    /**
     * @Route("/{group_id}/text/{text_id}/individual/vote", name="individual_text_vote")
     * @ParamConverter("textGroup", class="AppBundle:Text\TextGroup", options={"id" = "group_id"})
     * @ParamConverter("text", class="AppBundle:Text\Text", options={"id" = "text_id"})
     */
    public function individualVoteAction(Request $request, TextGroup $textGroup, Text $text)
    {
        if ($textGroup->getId() != $text->getTextGroup()->getId()) {
            throw \AccessDeniedException();
        }
        $this->denyAccessUnlessGranted('vote', $textGroup);
        $this->denyAccessUnlessGranted('vote', $text);

        $form = $this->createFormBuilder()->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $adherent = $this->getUser()->getProfile();
            $em = $this->getDoctrine()->getManager();

            $av = new IndividualTextVote($adherent, $text);
            $av->setVote(IndividualTextVote::VOTE_FOR);
            $em->persist($av);
            $agregs = $em->getRepository('AppBundle:Vote\IndividualTextVoteAgregation')
                ->getAgregationForUserAndText($text, $adherent);

            foreach ($agregs as $agreg) {
                $agreg->setVoteFor($agreg->getVoteFor() + 1);
                $voteRule = $agreg->getVoteRule();
                if ($voteRule instanceof ThresholdVoteRule) {
                    if ($agreg->getVoteFor() >= $voteRule->getThreshold()) {
                        $text->setStatus(Text::STATUS_ADOPTED);
                        $em->persist($text);
                    }
                }
                $em->persist($agreg);
            }

            $em->flush();

            return $this->redirect($this->generateUrl('text_list', array('group_id' => $textGroup->getId())));
        }

        return $this->render('text/vote.html.twig', array(
            'textGroup' => $textGroup,
            'text' => $text,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{group_id}/report/{organ_id}/vote", name="report_vote")
     * @ParamConverter("textGroup", class="AppBundle:Text\TextGroup", options={"id" = "group_id"})
     * @ParamConverter("organ", class="AppBundle:Organ\Organ", options={"id" = "organ_id"})
     */
    public function reportVoteAction(Request $request, TextGroup $textGroup, Organ $organ)
    {
        $this->denyAccessUnlessGranted('report_vote', new TextGroupOrganPair($textGroup, $organ), $this->getUser());

        $adherent = $this->getUser()->getProfile();
        $iotv = new IndividualOrganTextVote($organ, $adherent, $textGroup);
        $form = $this->createIndividualOrganTextVoteCreateForm($iotv);
        $errors = array();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $iotv = $form->getData();

            // TODO: use validator, instead of this ugly code..
            $sumVotes = $iotv->getVoteBlank() + $iotv->getVoteAbstention() + $iotv->getVoteNotTakingPart();
            foreach ($iotv->getTextVoteAgregations() as $aggr) {
                $sumVotes += $aggr->getVoteFor() + $aggr->getVoteAgainst() + $aggr->getVoteAbstention();
            }

            if ($sumVotes != $iotv->getVoteTotal()) {
                $errors[] = 'Le total des votes ne correspond pas aux votes rapportés';
            }

            if ($sumVotes > count($organ->getParticipants())) {
                $errors[] = 'Il y a plus de votes que de personnes inscrits dans le comité.';
            }

            if (count($errors) > 0) {
                return $this->render('text/report_vote.html.twig', array(
                    'textGroup' => $textGroup,
                    'organ' => $organ,
                    'form' => $form->createView(),
                    'errors' => $errors,
                ));
            }
            $em->persist($iotv);

            $em->flush();

            return $this->redirect($this->generateUrl('vote_report_show', array('group_id' => $textGroup->getId(), 'organ_id' => $organ->getId())));
        }

        return $this->render('text/report_vote.html.twig', array(
            'textGroup' => $textGroup,
            'organ' => $organ,
            'form' => $form->createView(),
            'errors' => $errors,
        ));
    }

    /**
     * Finds and displays a Text\Text entity.
     *
     * @Route("/{group_id}/report/{organ_id}/show", name="vote_report_show")
     *
     * @Method("GET")
     * @ParamConverter("textGroup", class="AppBundle:Text\TextGroup", options={"id" = "group_id"})
     * @ParamConverter("organ", class="AppBundle:Organ\Organ", options={"id" = "organ_id"})
     * @Template("text/report_show.html.twig")
     */
    public function showVoteReportAction(TextGroup $textGroup, Organ $organ)
    {
        $this->denyAccessUnlessGranted('view', $textGroup);
        $em = $this->getDoctrine()->getManager();
        $report = $em->getRepository('AppBundle:Vote\IndividualOrganTextVote')->getReport($organ, $textGroup);

        return array(
            'textGroup' => $textGroup,
            'organ' => $organ,
            'report' => $report,
        );
    }

    /**
     * Creates a form to create a Text\Text entity.
     *
     * @param Text $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Text $entity, TextGroup $textGroup)
    {
        $form = $this->createForm(new TextType(), $entity, array(
            'action' => $this->generateUrl('text_create', array('group_id' => $textGroup->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Creer'));

        return $form;
    }

    /**
     * Creates a form to create a Vote\IndividualOrganTextVote entity.
     *
     * @param IndividualOrganTextVote $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createIndividualOrganTextVoteCreateForm(IndividualOrganTextVote $entity)
    {
        $form = $this->createForm(new IndividualOrganTextVoteType(), $entity, array(
            'action' => $this->generateUrl('report_vote', array(
                'group_id' => $entity->getTextGroup()->getId(),
                'organ_id' => $entity->getOrgan()->getId(), )),
            'method' => 'POST',
            'vote_modality' => $entity->getTextGroup()->getVoteModality(),
        ));

        $form->add('submit', 'submit', array('label' => 'Soumettre', 'attr' => array('class' => 'btn btn-primary')));

        return $form;
    }
}
