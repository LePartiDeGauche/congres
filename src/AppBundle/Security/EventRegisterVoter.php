<?php

namespace AppBundle\Security;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class EventRegisterVoter implements VoterInterface
{
    const EVENT_REGISTER = 'event-register';
    const EVENT_CLASS = 'AppBundle\Entity\Event\Event';

    /**
     * {@inheritdoc}
     */
    public function supportsAttribute($attribute)
    {
        return self::EVENT_REGISTER === $attribute;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return self::EVENT_CLASS === $class;
    }

    /**
     * {@inheritdoc}
     */
    public function vote(TokenInterface $token, $event, array $attributes)
    {
        if (!$this->supportsClass(get_class($event)) || !isset($attributes[0]) || !$this->supportsAttribute($attributes[0])) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        $adherent = $token->getUser()->getProfile();
        foreach ($event->getRoles() as $role) {
            $responsabilities = $role->getRequiredResponsabilities();
            if (count($responsabilities) == 0) {
                // No responsability required for this role. Let's grant user
                return VoterInterface::ACCESS_GRANTED;
            }
            foreach ($responsabilities as $responsability) {
                if ($adherent->hasResponsability($responsability)) {
                    return VoterInterface::ACCESS_GRANTED;
                }
            }
        }

        if (in_array('ROLE_ADMIN', $token->getUser()->getRoles(), true)) {
            return VoterInterface::ACCESS_GRANTED;
        }

        return VoterInterface::ACCESS_DENIED;
    }
}
