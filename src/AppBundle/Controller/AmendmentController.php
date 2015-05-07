<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Text\Amendment controller.
 *
 * @Route("/amendement")
 */
class AmendmentController extends Controller
{
    /**
     * @param Request $request
     *
     * @Route("/envoyer", name="amendment_submit")
     */
    public function submitAction(Request $request)
    {

    }





    
    /**
     * Lists all Text\Amendment entities.
     *
     * @Route("/", name="text_amendment")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Text\Amendment')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Text\Amendment entity.
     *
     * @Route("/", name="text_amendment_create")
     * @Method("POST")
     * @Template("AppBundle:Text\Amendment:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Amendment();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('text_amendment_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Text\Amendment entity.
     *
     * @param Amendment $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Amendment $entity)
    {
        $form = $this->createForm(new AmendmentType(), $entity, array(
            'action' => $this->generateUrl('text_amendment_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Text\Amendment entity.
     *
     * @Route("/new", name="text_amendment_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Amendment();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Text\Amendment entity.
     *
     * @Route("/{id}", name="text_amendment_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Text\Amendment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Text\Amendment entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Text\Amendment entity.
     *
     * @Route("/{id}/edit", name="text_amendment_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Text\Amendment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Text\Amendment entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Text\Amendment entity.
    *
    * @param Amendment $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Amendment $entity)
    {
        $form = $this->createForm(new AmendmentType(), $entity, array(
            'action' => $this->generateUrl('text_amendment_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Text\Amendment entity.
     *
     * @Route("/{id}", name="text_amendment_update")
     * @Method("PUT")
     * @Template("AppBundle:Text\Amendment:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Text\Amendment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Text\Amendment entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('text_amendment_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Text\Amendment entity.
     *
     * @Route("/{id}", name="text_amendment_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Text\Amendment')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Text\Amendment entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('text_amendment'));
    }

    /**
     * Creates a form to delete a Text\Amendment entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('text_amendment_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
