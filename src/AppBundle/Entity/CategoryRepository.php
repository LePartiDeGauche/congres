<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;


/**
 * CategoryRepository.
 */
class CategoryRepository  extends EntityRepository
{
    public function findActiveCategory() {
        return $this
            ->createQueryBuilder('c')
            ->select('c')
            ->where('c.isActive = 1')
            ->getQuery()
            ->getResult()
            ;
    }
}
