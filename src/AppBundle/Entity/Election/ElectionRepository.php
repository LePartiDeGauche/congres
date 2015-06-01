<?php

namespace AppBundle\Entity\Election;

use AppBundle\Entity\Adherent;
use AppBundle\Entity\AdherentResponsability;
use AppBundle\Entity\Organ\OrganParticipation;
use Doctrine\ORM\EntityRepository;

/**
 * ElectionRepository.
 */
class ElectionRepository extends EntityRepository
{
    public function findAllWithResponsable()
    {
        return $this
            ->createQueryBuilder('e')
            ->join('e.electionGroup', 'g')
            ->join('e.organ', 'o')
            ->join('o.designatedParticipants', 'r')
            ->join('r.adherent', 'a')
            ->join('a.user', 'u')
            ->join('r.responsability', 're')
            //->where('e = :election')
            //->setParameter('election', $election)
            ->andWhere('r.responsability = g.responsableResponsability')
            ->andWhere('r.isActive = 1')
            ->getQuery()
            ->getResult()
        ;
    }
}
