<?php

namespace AppBundle\Security;

use Symfony\Component\Security\Core\Authorization\Voter\AbstractVoter;

use AppBundle\Entity\Event\Event;
use AppBundle\Entity\User;

final class EventRegisterVoter extends AbstractVoter
{
    const EVENT_REGISTER = 'event-register';
    const EVENT_VIEW = 'view';
    const EVENT_CLASS = 'AppBundle\Entity\Event\Event';

    private $entityManager;
    private $container;

    protected function getSupportedAttributes()
    {
        return array(self::EVENT_VIEW, self::EVENT_REGISTER);
    }

    protected function getSupportedClasses()
    {
        return array(
            self::EVENT_CLASS,
        );
    }

    protected function isGranted($attribute, $event, $user = null)
    {
        if (!$user instanceof User) {
            return false;
        }

        if ($attribute === self::EVENT_VIEW) {
            return $this->canView($event, $user);
        }

        if ($attribute === self::EVENT_REGISTER) {
            return $this->canRegister($event, $user);
        }

        return false;
    }

    private function canView(Event $event, User $user)
    {
        // FIXME : in_array does not take into account role hierarchy !
        return ($event->getIsVisible() ||
            in_array('ROLE_ADMIN', $user->getRoles(), true));
    }

    /**
     * {@inheritdoc}
     */
    private function canRegister(Event $event, User $user)
    {
        // TODO voter (no time for this now...)
        if (!$this->canView($event, $user)) {
            return false;
        }

        $now = new \DateTime('now');
        if ($now < $event->getRegistrationBegin() || $now > $event->getRegistrationEnd()) {
            // throw new AccessDeniedException('Les inscriptions ne sont pas ouvertes');
            return false;
        }

        $adherent = $user->getProfile();
        foreach ($event->getRoles() as $role) {
            $responsabilities = $role->getRequiredResponsabilities();
            if (count($responsabilities) == 0) {
                // No responsability required for this role. Let's grant user
                return true;
            }
            foreach ($responsabilities as $responsability) {
                if ($adherent->hasResponsability($responsability)) {
                    return true;
                }
            }
        }

        return false;
    }


}
