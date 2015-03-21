<?php

namespace AppBundle\Entity\Vote;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use AppBundle\Entity\Adherent;
use AppBundle\Entity\Text\Text;

class IndividualTextVoteAgregationRepository extends EntityRepository
{
    protected $classname;

    public function getAgregationForUserAndText(Text $text, Adherent $adherent)
    {
        return $this->createQueryBuilder('ar')
            ->innerJoin('ar.textGroup', 'tg')
            ->innerJoin('tg.voteRules', 'vr')
            ->innerJoin('vr.concernedResponsability', 'concresp')
            ->innerJoin('concresp.adherentResponsabilities' , 'adhresp')
            ->where('ar.text = :text')
            ->andWhere('adhresp.adherent = :adherent OR SIZE(vr.concernedResponsability) = 0')
            ->setParameter('text', $text->getId())
            ->setParameter('adherent', $adherent->getId())->getQuery()->getResult();
            ;
    }

}
