<?php

namespace AppBundle\Entity\Text;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Adherent;

/**
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TextGroupRepository extends EntityRepository
{
    protected $classname;

    public function getOrganAdherentCanReportFor(Adherent $adherent)
    {
        $organs = $this->createQueryBuilder('tg')
            ->select('organ')
            ->from('AppBundle:Organ\Organ', 'organ')
            ->leftJoin('tg.organVoteRules', 'ovr')
            ->leftJoin('ovr.reportResponsability', 'rr')
            ->leftJoin('rr.adherentResponsabilities', 'adhresp')
            ->leftJoin('adhresp.designatedByOrgan', 'org')
            ->where('adhresp.adherent = :adherent')
            ->andWhere('organ.id = org.id')
            ->setParameter('adherent', $adherent->getId())
            ->getQuery();

        return $organs->getResult();
    }
}
