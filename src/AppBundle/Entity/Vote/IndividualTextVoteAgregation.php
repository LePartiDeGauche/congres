<?php

namespace AppBundle\Entity\Vote;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Text\Text;
use AppBundle\Entity\Text\TextGroup;

/**
 * AppBundle\Entity\Vote\IndividualTextVoteAgregation
 *
 * @ORM\Entity(
 * repositoryClass="AppBundle\Entity\Vote\IndividualTextVoteAgregationRepository"
 * )
 * @ORM\Table(name="individual_text_vote_agregation")
 *
 */
class IndividualTextVoteAgregation extends TextVoteAgregation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="VoteRule",
     * cascade={"persist", "remove", "merge"})
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $voteRule;

    public function __construct(Text $text, TextGroup $textGroup, VoteRule $voteRule)
    {
        parent::__construct($text, $textGroup);
        $this->voteRule = $voteRule;
    }

    /**
     * Set voteRule
     *
     * @param  \stdClass                    $voteRule
     * @return IndividualTextVoteAgregation
     */
    public function setVoteRule($voteRule)
    {
        $this->voteRule = $voteRule;

        return $this;
    }

    /**
     * Get voteRule
     *
     * @return \stdClass
     */
    public function getVoteRule()
    {
        return $this->voteRule;
    }

}
