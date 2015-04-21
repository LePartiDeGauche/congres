<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Vote\IndividualTextVote;
use AppBundle\Entity\Vote\IndividualTextVoteAgregation;
use AppBundle\Entity\Vote\ThresholdVoteRule;
use AppBundle\Entity\Text\TextGroup;
use AppBundle\Entity\Text\Text;
use AppBundle\Entity\User;
use AppBundle\Entity\Organ\Organ;
use AppBundle\Form\Text\TextType;
use AppBundle\TextGroupOrganPair;

/**
 * Text\Text controller.
 *
 * @Route("/textgroup")
 */
class TextController extends Controller
{

    /**
     * Lists all Text\Text entities.
     *
     * @Route("/{group_id}/list", name="text_list")
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
        if ($textGroup->getVoteType() == TextGroup::VOTETYPE_COLLECTIVE)
        {
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
            'adherent' => $user->getProfile()
        ));
    }

    /**
     * Finds and displays a Text\Text entity.
     *
     * @Route("/{group_id}/text/{text_id}", name="text_show")
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
            'textGroup'      => $textGroup,
            'text'      => $text
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

        if ($form->isValid() && $form->getData()->getRawContent() != null)
        {
            $text = $form->getData();
            $text->setTextGroup($textGroup);
            foreach ($textGroup->getVoteRules() as $voteRule)
            {
                $itva = new IndividualTextVoteAgregation($text, $textGroup, $voteRule);
                $text->addIndividualVoteAgregation($itva);
                $this->getDoctrine()->getManager()->persist($itva);
            }
            $this->getDoctrine()->getManager()->persist($text);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('text_user_list'));

        }
        return $this->render('text/new.html.twig', array(
            'textGroup'      => $textGroup,
            'text'      => $text,
            'form'  => $form->createView())
        );
    }
    /**
     * @Route("/{group_id}/text/{text_id}/individual/vote", name="individual_text_vote")
     * @ParamConverter("textGroup", class="AppBundle:Text\TextGroup", options={"id" = "group_id"})
     * @ParamConverter("text", class="AppBundle:Text\Text", options={"id" = "text_id"})
     *
     */
    public function individualVoteAction(Request $request, TextGroup $textGroup, Text $text)
    {
        if ($textGroup->getId() != $text->getTextGroup()->getId())
        {
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

            foreach($agregs as $agreg)
            {
                $agreg->setVoteFor($agreg->getVoteFor() + 1);
                $voteRule =  $agreg->getVoteRule();
                if ($voteRule instanceof ThresholdVoteRule)
                {
                    if ($agreg->getVoteFor() >= $voteRule->getThreshold())
                    {
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
     *
     */
    public function reportVoteAction(Request $request, TextGroup $textGroup, Organ $organ)
    {
        $this->denyAccessUnlessGranted('report_vote', new TextGroupOrganPair($textGroup, $organ), $this->getUser());

        $iotv = new IndividualOrganTextVote($organ, $adherent, $textGroup);
        $form = $this->createCreateForm($text, $textGroup);
        $form = $this->createFormBuilder()->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $adherent = $this->getUser()->getProfile();
            $em = $this->getDoctrine()->getManager();

            $em->persist($av);

            $em->flush();
            return $this->redirect($this->generateUrl('text_list', array('group_id' => $textGroup->getId())));
        }

        return $this->render('text/individual_organ_vote.html.twig', array(
            'textGroup' => $textGroup,
            'text' => $text,
            'form' => $form->createView(),
        ));
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
            'action' => $this->generateUrl('individual_organ_text_vote',array(
                'group_id' => $entity->textGoup->getId(),
                'organ_id' => $entity->organ->getId())),
            'method' => 'POST',
            'vote_modality' => $entity->textGroup->getVoteModality(),
        ));

        $form->add('submit', 'submit', array('label' => 'Creer'));

        return $form;
    }
}
