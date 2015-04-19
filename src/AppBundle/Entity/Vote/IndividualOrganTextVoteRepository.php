<?php

namespace AppBundle\Entity\Vote;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
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
            ->setParameter('text', $textGroup->getId())
            ->getQuery()->getSingleScalarResult();

        return !!$voteCount;

    
    }

}
