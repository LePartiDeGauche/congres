<?php

namespace AppBundle\Security;

use Symfony\Component\Security\Core\Authorization\Voter\AbstractVoter;

use AppBundle\Entity\Election\CandidatureCall;
use AppBundle\Entity\User;

final class CandidatureCallVoter extends AbstractVoter
{
    const CANDIDATURE_CREATE = 'create';
    const CANDIDATURE_DELETE = 'delete';
    const CANDIDATURE_VIEW = 'view';
    const CANDIDATURE_CLASS = 'AppBundle\Entity\Election\CandidatureCall';

    private $entityManager;
    private $container;

    protected function getSupportedAttributes()
    {
        return array(
            self::CANDIDATURE_CREATE,
            self::CANDIDATURE_VIEW,
            self::CANDIDATURE_DELETE
        );
    }

    protected function getSupportedClasses()
    {
        return array(
            self::CANDIDATURE_CLASS,
        );
    }

    protected function isGranted($attribute, $candidature, $user = null)
    {
        if (!$user instanceof User) {
            return self::ACCESS_DENIED;
        }

        if ($attribute === self::CANDIDATURE_VIEW) {
            return $this->canView($candidature, $user);
        }

        if ($attribute === self::CANDIDATURE_CREATE || $attribute === self::CANDIDATURE_DELETE) {
            return $this->canRegister($candidature, $user);
        }

        return self::ACCESS_DENIED;
    }

    private function canView(CandidatureCall $candidature, User $user)
    {
        // FIXME : in_array does not take into account role hierarchy !
        if (in_array('ROLE_ADMIN', $user->getRoles(), true)) {
            return self::ACCESS_GRANTED;
        }
        $now = new \DateTime('now');
        if ($candidature->getIsVisible() && $now > $candidature->getOpeningDate() && $now < $candidature->getClosingDate()) {
            // throw new AccessDeniedException('Les inscriptions ne sont pas ouvertes');
            return self::ACCESS_GRANTED;
        }
        return self::ACCESS_ABSTAIN;;
    }

    /**
     * {@inheritdoc}
     */
    private function canRegister(CandidatureCall $candidature, User $user)
    {
        // TODO voter (no time for this now...)
        if ($this->canView($candidature, $user)) {
            return self::ACCESS_GRANTED;
        }
        return self::ACCESS_ABSTAIN;
    }


}
