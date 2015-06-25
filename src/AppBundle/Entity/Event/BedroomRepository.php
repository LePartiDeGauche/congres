<?php

namespace AppBundle\Entity\Event;

use Doctrine\ORM\EntityRepository;


/**
 * BedroomRepository.
 */
class BedroomRepository  extends EntityRepository
{
    public function findBedroomsActivesByDate(\DateTime $date) {

        return $this
            ->createQueryBuilder('b')
            ->where('b.dateStartAvailability <= :date')
            ->andWhere('b.dateStopAvailability >= :date')
            ->setParameters([
                'date' => $date,
            ])
            ->getQuery()
            ->getResult()
        ;
    }

    public function findBedroomsNextCurrentDate()
    {
        return $this
            ->createQueryBuilder('b')
            ->where('b.dateStartAvailability >= :date')
            ->setParameters([
                'date' => new \DateTime('-20 days'),
            ])
            ->getQuery()
            ->getResult()
            ;
    }
}