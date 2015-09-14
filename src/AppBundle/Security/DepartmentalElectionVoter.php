<?php

namespace AppBundle\Security;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Responsability;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;


class DepartmentalElectionVoter extends VoterInterface
{
    const DEPARTMENT_ELECTION_REPORT = 'DEPARTMENT_ELECTION_REPORT';
    const DEPARTMENT_ELECTION_CLASS = 'AppBundle\Entity\Election\Election';

    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

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

    /**
     * {@inheritdoc}
     */
    public function vote(TokenInterface $token, $object, array $attributes)
    {
        if (!$this->supportsClass(get_class($object)) || !isset($attributes[0]) || !$this->supportsAttribute($attributes[0])) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        //User courant
        $adherent = $object->getUser()->getProfile();

        //Responsability co-secrétaire
        $responsability = $this->entityManager
            ->getRepository('AppBundle:Responsability')
            ->findByName('Co-secrétaire départemental');

        //Réupération d'une responsabilité par adhérent si active
        $adherentResponsability = $this->entityManager
            ->getRepository('AppBundle:AdherentResponsability')
            ->findActiveResponsabilityByAdherent($adherent, $responsability);

        //Si l'user courant est un co-secrétaire actif
        if($adherentResponsability) {
            foreach ($adherentResponsability as $key) {
                $responsabilityAdherent = $key->getResponsability();
            }
            foreach($responsability as $key)
            {
                $responsability = $key;
            }

            if ($responsabilityAdherent == $responsability)
            {
                return VoterInterface::ACCESS_GRANTED;
            }
            else
            {
                return VoterInterface::ACCESS_DENIED;
            }
        }

        return VoterInterface::ACCESS_DENIED;

    }

}