<?php

namespace AppBundle\Entity\Event;

use Doctrine\ORM\EntityRepository;

/**
 * BedroomRepository.
 */
class BedroomRepository  extends EntityRepository
{
    public function findPlacesByBedroom(Bedroom $bedroom)
    {
        return $this
            ->createQueryBuilder('b')
            ->join('b.roomType', 'r')
            ->getQuery()
            ->getResult()
        ;
    }
}