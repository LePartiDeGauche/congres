<?php

namespace AppBundle\Entity\Vote;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Adherent;
use AppBundle\Entity\Text\Text;

class IndividualTextVoteAgregationRepository extends EntityRepository
{
    protected $classname;

    public function getAgregationForUserAndText(Text $text, Adherent $adherent)
    {
        // FIXME this request should return only agregator related to user right, but it returns
        // every agregetor related to the text...
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
