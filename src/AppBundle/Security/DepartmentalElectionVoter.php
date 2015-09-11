<?php

namespace AppBundle\Security;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;


class DepartmentalElectionVoter extends  VoterInterface
{
    const DEPARTMENT_ELECTION_REPORT = 'DEPARTMENT_ELECTION_REPORT';
    const DEPARTMENT_ELECTION_CLASS = 'AppBundle\Entity\Election\Election';

    /**
     * {@inheritdoc}
     */
    public function supportsAttribute($attribute)
    {
        return self::DEPARTMENT_ELECTION_REPORT === $attribute;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return self::DEPARTMENT_ELECTION_CLASS === $class;
    }


}