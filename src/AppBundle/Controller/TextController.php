<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Text\TextGroup;
use AppBundle\Entity\Text\Text;
use AppBundle\Entity\User;
use AppBundle\Form\Text\TextType;

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
        $em = $this->getDoctrine()->getManager();

        $texts = $em->getRepository('AppBundle:Text\Text')->findByTextGroup($textGroup);

        return $this->render('text/list.html.twig', array(
            'textGroup' => $textGroup,
            'texts' => $texts,
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
     * @Template("event/show.html.twig")
     */
    public function showAction(TextGroup $textGroup, Text $text)
    {

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
        $text = new Text($this->getUser()->getProfile());
        $form = $this->createCreateForm($text, $textGroup);

        $form->handleRequest($request);

        if ($form->isValid())
        {
            $text = $form->getData();
            $text->setTextGroup($textGroup);
            $this->getDoctrine()->getManager()->persist($text);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('text_list', array('group_id' => $textGroup->getId())));

        }
        return $this->render('text/new.html.twig', array(
            'textGroup'      => $textGroup,
            'text'      => $text,
            'form'  => $form->createView())
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
}
