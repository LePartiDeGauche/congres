<?php

namespace AppBundle\Admin\Congres\Controller;

use AppBundle\Entity\Congres\Contribution;
use Sonata\AdminBundle\Controller\CRUDController;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\AccessDeniedException;

class ContributionAdminController extends CRUDCOntroller
{
    public function batchActionEditStatusNew(ProxyQueryInterface $selectedModelQuery)
    {
        return $this->batchActionEditStatus($selectedModelQuery, Contribution::STATUS_NEW);
    }

    public function batchActionEditStatusClosed(ProxyQueryInterface $selectedModelQuery)
    {
        return $this->batchActionEditStatus($selectedModelQuery, Contribution::STATUS_SIGNATURES_CLOSED);
    }

    public function batchActionEditStatusRejected(ProxyQueryInterface $selectedModelQuery)
    {
        return $this->batchActionEditStatus($selectedModelQuery, Contribution::STATUS_REJECTED);
    }

    public function batchActionEditStatusOpen(ProxyQueryInterface $selectedModelQuery)
    {
        return $this->batchActionEditStatus($selectedModelQuery, Contribution::STATUS_SIGNATURES_OPEN);
    }

    private function batchActionEditStatus(ProxyQueryInterface $selectedModelQuery, $status)
    {
        if (!$this->admin->isGranted('EDIT') || !$this->admin->isGranted('DELETE')) {
            throw new AccessDeniedException();
        }

        $modelManager = $this->admin->getModelManager();
        $selectedModels = $selectedModelQuery->execute();

        try {
            foreach ($selectedModels as $selectedModel) {
                $selectedModel->setStatus($status);
            }

            $modelManager->update($selectedModel);
        } catch (\Exception $e) {
            $this->addFlash('sonata_flash_error', 'Erreur.');

            return new RedirectResponse(
                $this->admin->generateUrl('list', $this->admin->getFilterParameters())
            );
        }

        $this->addFlash('sonata_flash_success', 'Statut modifié.');

        return new RedirectResponse(
            $this->admin->generateUrl('list', $this->admin->getFilterParameters())
        );
    }
}
