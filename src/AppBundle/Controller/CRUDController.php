<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CRUDController extends Controller
{
    public function cloneAction()
    {
        $object = $this->admin->getSubject();

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        // Be careful, you may need to overload the __clone method of your object
        // to set its id to null !
        $clonedObject = clone $object;

        $this->admin->create($clonedObject);

        $this->addFlash('sonata_flash_success', 'La copie a été effectuée');

        return new RedirectResponse($this->admin->generateUrl('list'));

        // if you have a filtererd list and want to keep your filters after the redirect
        // return new RedirectResponse($this->admin->generateUrl('list'), $this->admin->getFilterParameters());
    }
}
