<?php

namespace AppBundle\Entity\Vote;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Text\Text;
use AppBundle\Entity\Text\TextGroup;
use AppBundle\Entity\Vote\TextVoteAgregation;

/**
 * AppBundle\Entity\Vote\IndividualOrganTextVoteAgregation
 *
 * @ORM\Entity()
 * @ORM\Table(name="individual_organ_text_vote_agregation")
 */
class IndividualOrganTextVoteAgregation extends TextVoteAgregation
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
     * @ORM\ManyToOne(targetEntity="IndividualOrganTextVote",
     * cascade={"persist", "remove", "merge"}, 
     * inversedBy="textVoteAgregations")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $individualOrganTextVote;


    public function __construct(Text $text, TextGroup $textGroup, IndividualOrganTextVote $individualOrganTextVote)
    {
        parent::__construct($text, $textGroup);
        $this->individualOrganTextVote = $individualOrganTextVote;
    }

    /**
     * Set voteRule
     *
     * @param \stdClass $voteRule
     * @return IndividualOrganTextVoteAgregation
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
