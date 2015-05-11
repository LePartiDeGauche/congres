<?php

namespace AppBundle\Entity\Vote;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Organ\Organ;
use AppBundle\Entity\Text\TextGroup;

class IndividualOrganTextVoteRepository extends EntityRepository
{
    protected $classname;

    public function hasVoteBeenReported(Organ $organ, TextGroup $textGroup)
    {
        $voteCount = $this->createQueryBuilder('iotv')
            ->select('COUNT(iotv)')
            ->where('iotv.textGroup = :textGroup')
            ->andWhere('iotv.organ = :organ')
            ->setParameter('organ', $organ->getId())
            ->setParameter('textGroup', $textGroup->getId())
            ->getQuery()->getSingleScalarResult();

        return !!$voteCount;
    }

    public function getReport(Organ $organ, TextGroup $textGroup)
    {
        $report = $this->createQueryBuilder('iotv')
            ->select('iotv')
            ->where('iotv.textGroup = :textGroup')
            ->andWhere('iotv.organ = :organ')
            ->setParameter('organ', $organ->getId())
            ->setParameter('textGroup', $textGroup->getId())
            ->getQuery()->getSingleResult();

        return $report;
    }
}
