<?php

namespace AppBundle\Entity\Event;

use Doctrine\ORM\EntityRepository;

/**
 * BedroomBookingRepository.
 */
class BedroomBookingRepository  extends EntityRepository
{
    public function countBookingsByBedroom(Bedroom $bedroom)
    {
        return $this
            ->createQueryBuilder('b')
            ->select('COUNT(b)')
            ->where('b.bedroom = :bedroom')
            ->setParameter('bedroom', $bedroom)
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

}