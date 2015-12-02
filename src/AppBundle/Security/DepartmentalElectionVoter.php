<?php

namespace AppBundle\Security;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Responsability;
use Symfony\Component\Security\Core\Authorization\Voter\AbstractVoter;

class DepartmentalElectionVoter extends AbstractVoter
{
    const DEPARTMENT_ELECTION_REPORT = 'DEPARTMENT_ELECTION_REPORT';
    const DEPARTMENT_ELECTION_CLASS = 'AppBundle\Entity\Adherent';

    private $entityManager;
    private $coSecretaireDepartementalId;

    public function __construct(EntityManager $entityManager, $coSecretaireDepartementalId)
    {
        $this->entityManager = $entityManager;
        $this->coSecretaireDepartementalId = $coSecretaireDepartementalId;
    }

    /**
     * {@inheritdoc}
     */
    protected function getSupportedAttributes()
    {
        return [self::DEPARTMENT_ELECTION_REPORT];
    }

    /**
     * {@inheritdoc}
     */
    protected function getSupportedClasses()
    {
        return [self::DEPARTMENT_ELECTION_CLASS];
    }

    /**
     * {@inheritdoc}
     */
    protected function isGranted($attribute, $object, $user = null)
    {
        if (!$user instanceof User || null === $user->getProfile()) {
            return false;
        }

        // Responsability co-secrétaire
        $responsability = $this
            ->entityManager
            ->getRepository('AppBundle:Responsability')
            ->find($this->coSecretaireDepartementalId)
        ;

        // Récupération d'une responsabilité par adhérent si active
        return $this
            ->entityManager
            ->getRepository('AppBundle:AdherentResponsability')
            ->hasActiveResponsibility($user->getProfile(), $responsability)
        ;
    }
}
