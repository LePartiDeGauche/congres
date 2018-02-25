<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Organ\Organ;
use Doctrine\ORM\EntityRepository;

/**
 * AdherentRepository.
 */
class AdherentRepository extends EntityRepository
{
    public function findAdherentsByTypedText($typedText)
    {
        $queryBuilder = $this
            ->createQueryBuilder('a')
            ->select('a.id, a.firstname, a.lastname, a.email')
            ->andWhere('a.firstname LIKE :typed_text')
            ->orWhere('a.lastname LIKE :typed_text')
            ->orWhere('a.email LIKE :typed_text')
            ->setParameter('typed_text', '%' . $typedText . '%')
        ;
        return $queryBuilder->getQuery()->getResult();
    }

    public function findAdherentByEmail(Adherent $adherent)
    {
        $adherent = $this->createQueryBuilder('a')
            ->select('a')
            ->where('a.email = :email')
            ->setParameter('email', $adherent->getEmail())
            ->getQuery();

        return $adherent->getResult();
    }

    public function getSearchAdherentByOrganQueryBuilder(Organ $organ)
    {
        $qb =
            $this->createQueryBuilder('a')
                //->join('a.user', 'u')
                ->join('a.organParticipations', 'o')
                ->where('o.organ = :organ')
                ->setParameter('organ', $organ)
                ->orderBy('a.lastname', 'ASC')
                ->setMaxResults(300)
        ;

        return $qb;
    }

//    public function getSearchAdherentByDepartmentBuilder(Organ $organ)
//    {
//        $qb =
//            $this->createQueryBuilder('a')
//                ->join('a.user', 'u')
//                ->join('a.organParticipations', 'o')
//                ->where('o.organ = :organ')
//                ->setParameter('organ', $organ)
//                ->orderBy('a.lastname', 'ASC')
//                ->setMaxResults(300)
//        ;
//
//        return $qb;
//    }
}
