<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * AdherentRepository.
 */
class AdherentRepository extends EntityRepository
{
    public function findAdherentsByTypedText($typedText)
    {
        $typedTexts = explode(' ', $typedText);

        $queryBuilder = $this
            ->createQueryBuilder('a')
            ->select('a.id, a.firstname, a.lastname')
        ;

        foreach($typedTexts as $key => $value) {
            $placeholder = sprintf('name_%s', $key);

            $queryBuilder
                ->orWhere('a.firstname LIKE :'.$placeholder)
                ->orWhere('a.lastname LIKE :'.$placeholder)
                ->setParameter($placeholder, '%'.$value.'%')
            ;
        }

        return $queryBuilder->getQuery()->getArrayResult();
    }
}
