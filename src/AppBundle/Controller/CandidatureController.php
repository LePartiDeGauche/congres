<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Election\Candidature;
use AppBundle\Form\Election\CandidatureType;

/**
 * Candidature controller.
 *
 * @Route("/candidature")
 */
class CandidatureController extends Controller
{
    /**
     * Finds and displays a Candidature entity.
     *
     * @Route("/create", name="candidature_create")
     */
    public function createAction(Request $request)
    {
        //$this->denyAccessUnlessGranted('candidate', $this->getUser());

        $form = $this->createForm(
            new CandidatureType(),
            new Candidature($this->getUser()->getProfile())
        );

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $form->getData()->setAuthor($this->getUser()->getProfile());

            if ($form->isValid()) {
                $manager = $this->getDoctrine()->getManager();

                $manager->persist($form->getData());
                $manager->flush();

                $this
                    ->get('session')
                    ->getFlashBag()
                    ->add(
                        'success',
                        'Candidature enregistrée. Remplissez à nouveau ce formulaire pour en proposer une autre.'
                    )
                ;

                return $this->redirect($this->generateUrl('candidature_list'));
                //return $this->render('candidature/candidature_success.html.twig', array('variable' => $data['idinstance']));
            }
        }

        return $this->render('candidature/candidature_create.html.twig', array(
            'form' => isset($displayedForm) ? $displayedForm->createView() : $form->createView(),
        ));
    }

    /**
     * Finds and displays a Candidature entity.
     *
     * @Route("/")
     * @Route("/list", name="candidature_list")
     */
    public function listAction(Request $request)
    {
        $id = $this->getUser()->getProfile();
        $repository = $this->getDoctrine()->getRepository('AppBundle:Election\Candidature');

        $query = $repository->createQueryBuilder('p')
            ->where('p.author=:author')
            ->setParameter('author', $id)
            ->getQuery();

        $result = $query->getResult();

        return $this->render('candidature/candidature_list.html.twig', array('result' => $result));
    }

    /**
     * @Route("/delete/{id}", name="candidature_delete")
     */
    public function deleteAction(Candidature $candidature)
    {
        if ($candidature->getAuthor() == $this->getUser()->getProfile()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($candidature);
            $em->flush();

            $this->get('session')
                ->getFlashBag()
                ->add('success', 'Candidature supprimée.');
        } else {
            $this->get('session')
                ->getFlashBag()
                ->add('error', 'Impossible de supprimer la candidature');
        }

        return $this->redirect($this->generateUrl('candidature_list'));
    }
}
