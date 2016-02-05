<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;


/**
 * PageRepository.
 */
class PageRepository  extends EntityRepository
{
    public function findActivePage() {
        return $this
            ->createQueryBuilder('p')
            ->where('p.isActive = 1')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findActivePageByCategory(Category $category) {
        return $this
            ->createQueryBuilder('p')
            ->where('p.isActive = 1')
            ->andWhere('p.category = :category')
            ->setParameter('category', $category)
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }
}
