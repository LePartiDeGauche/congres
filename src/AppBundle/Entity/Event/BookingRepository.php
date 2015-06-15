<?php

namespace AppBundle\Entity\Event;

use Doctrine\ORM\EntityRepository;

class BookingRepository extends EntityRepository
{
    public function findFor(Bedroom $bedroom, \DateTime $date)
    {
        $dateEnd = clone $date;
        $dateEnd->add(new \DateInterval('P1D'));

        $this
            ->createQueryBuilder('b')
            ->where('b.bedroom = :bedroom')
            ->andWhere('b.date >= :dateStart')
            ->andWhere('b.date < :dateEnd')
            ->setParameters([
                'bedroom' => $bedroom,
                'dateStart' => $date,
                'dateEnd' => $dateEnd,
            ])
            ->getQuery()
            ->getResult()
        ;
    }


}
