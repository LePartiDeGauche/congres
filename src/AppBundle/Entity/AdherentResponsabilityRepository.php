<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ContributionRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AdherentResponsabilityRepository extends EntityRepository
{
    protected $classname;

    public function findOldResponsabilityByAdherentAndResponsability(Adherent $adherent, \DateTime $currentDate, Responsability $responsability)
    {
        return $adherentResponsability = $this
            ->createQueryBuilder('ar')
            ->select('ar')
            ->where('ar.adherent = :adherent')
            ->andWhere('ar.start < :currentDate')
            ->andWhere('ar.responsability = :responsability')
            ->setParameter('adherent', $adherent)
            ->setParameter('currentDate', $currentDate)
            ->setParameter('responsability', $responsability)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findActiveResponsabilityByAdherent(Adherent $adherent, $responsability)
    {
        return $adherentResponsability = $this
            ->createQueryBuilder('ar')
            ->select('ar')
            ->where('ar.adherent = :adherent')
            ->andWhere('ar.responsability = :responsability')
            ->andWhere('ar.isActive = 1')
            ->setParameter('adherent', $adherent)
            ->setParameter('responsability', $responsability)
            ->getQuery()
            ->getResult()
            ;
    }

}
