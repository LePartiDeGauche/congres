<?php

namespace AppBundle\Security;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class ElectionReportVoter implements VoterInterface
{
    const ELECTION_REPORT = 'ELECTION_REPORT';
    const ELECTION_CLASS = 'AppBundle\Entity\Election\Election';

    /**
     * {@inheritdoc}
     */
    public function supportsAttribute($attribute)
    {
        return self::ELECTION_REPORT === $attribute;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return self::ELECTION_CLASS === $class;
    }

    /**
     * {@inheritdoc}
     */
    public function vote(TokenInterface $token, $object, array $attributes)
    {
        if (!$this->supportsClass(get_class($object)) || !isset($attributes[0]) || !$this->supportsAttribute($attributes[0])) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        foreach ($object->getOrgan()->getDesignatedParticipants() as $responsability) {
            if ($responsability->getAdherent()->getUser() === $token->getUser()) {
                return VoterInterface::ACCESS_GRANTED;
            }
        }

        if (in_array('ROLE_ADMIN', $token->getUser()->getRoles(), true)) {
            return VoterInterface::ACCESS_GRANTED;
        }

        return VoterInterface::ACCESS_DENIED;
    }
}
