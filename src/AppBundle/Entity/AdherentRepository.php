<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Organ\Organ;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Adherent;
use AppBundle\Entity\User;



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

    public function findAdherentByEmail(Adherent $adherent)
    {
        $adherent = $this->createQueryBuilder('a')
            ->select('a')
            ->where('a.email = :email')
            ->setParameter('email', $adherent->getEmail())
            ->getQuery();
        ;
        return $adherent->getResult();
    }

    public function getSearchAdherentByOrganQueryBuilder(Organ $organ)
    {
        $qb =
            $this->createQueryBuilder('a')
                ->join('a.user', 'u')
                ->join('a.organParticipations', 'o')
                ->where('o.organ = :organ')
                ->setParameter('organ', $organ)
                ->orderBy('a.lastname', 'ASC')
                ->setMaxResults(100)
        ;

        return $qb;
    }
}
