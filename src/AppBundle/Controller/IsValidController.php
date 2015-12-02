<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AdherentResponsability;
use AppBundle\Entity\Responsability;
use AppBundle\Entity\Election\Election;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class IsValidController extends Controller
{
    public function validAction()
    {
        $id = $this->get('request')->get($this->admin->getIdParameter());
        $object = $this->admin->getObject($id);

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        $object->setIsValid(1);
        $object->setStatus(Election::ISVALID_TRUE);
        $this->admin->update($object);

        $elected = $object->getElected();
        foreach ($elected as $elected) {
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('AppBundle:Responsability')
            ;
            $responsability = $repository->findOneByName(Responsability::INSTANCE_DEL);

            $adherentResponsability = new AdherentResponsability();

            $adherentResponsability->setAdherent($elected);
            $adherentResponsability->setResponsability($responsability);
            $adherentResponsability->setIsActive(true);
            $adherentResponsability->setStart(new \DateTime('today'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($adherentResponsability);
            $em->flush();
        }

        $this->addFlash('sonata_flash_success', 'Election validée');

        return new RedirectResponse($this->admin->generateUrl('list'));
    }

    public function rejectAction()
    {
        $id = $this->get('request')->get($this->admin->getIdParameter());
        $object = $this->admin->getObject($id);

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        $object->setIsValid(0);
        $object->setStatus(Election::ISVALID_FALSE);

        $this->admin->update($object);

        $this->addFlash('sonata_flash_success', 'Election rejetée');

        return new RedirectResponse($this->admin->generateUrl('list'));
    }
}
