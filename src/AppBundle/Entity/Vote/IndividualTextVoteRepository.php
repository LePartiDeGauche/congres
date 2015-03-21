<?php

namespace AppBundle\Entity\Vote;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use AppBundle\Entity\Adherent;
use AppBundle\Entity\Text\TextGroup;
use AppBundle\Entity\Text\Text;

class IndividualTextVoteRepository extends EntityRepository
{
    protected $classname;

    public function getAdherentVoteCountByTextGroup(Adherent $author,TextGroup $textGroup)
    {
        $voteCount = $this->createQueryBuilder('itv')
            ->select('COUNT(itv)')
            ->leftJoin('itv.text', 'tx')
            ->where('tx.textGroup = :textGroup')
            ->andWhere('itv.author = :author')
            ->setParameter('author', $author->getId())
            ->setParameter('textGroup', $textGroup->getId())
            ->getQuery()->getSingleScalarResult();

        return $voteCount;
    }

    public function hasVoted(Adherent $adherent, Text $text)
    {
        $voteCount = $this->createQueryBuilder('itv')
            ->select('COUNT(itv)')
            ->where('itv.text = :text')
            ->andWhere('itv.author = :author')
            ->setParameter('author', $adherent->getId())
            ->setParameter('text', $text->getId())
            ->getQuery()->getSingleScalarResult();

        return $voteCount;

    
    }

}
