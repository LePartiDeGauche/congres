<?php

namespace AppBundle\Entity\Vote;

use Doctrine\ORM\Mapping as ORM;

/**
 * IndividualTextVoteAgregation
 *
 * @ORM\Table(name="individual_text_vote_agregation")
 * @ORM\Entity
 */
class IndividualTextVoteAgregation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="VoteRule")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $voteRule;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Text\Text", inversedBy="individualVoteAgregations")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $text;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Text\TextGroup")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $textGroup;

    /**
     * @var integer
     *
     * @ORM\Column(name="voteFor", type="integer")
     */
    private $voteFor;

    /**
     * @var integer
     *
     * @ORM\Column(name="voteAgainst", type="integer")
     */
    private $voteAgainst;

    /**
     * @var integer
     *
     * @ORM\Column(name="voteAbstention", type="integer")
     */
    private $voteAbstention;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set voteRule
     *
     * @param \stdClass $voteRule
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

    /**
     * Set text
     *
     * @param \stdClass $text
     * @return IndividualTextVoteAgregation
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return \stdClass 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set textGroup
     *
     * @param \stdClass $textGroup
     * @return IndividualTextVoteAgregation
     */
    public function setTextGroup($textGroup)
    {
        $this->textGroup = $textGroup;

        return $this;
    }

    /**
     * Get textGroup
     *
     * @return \stdClass 
     */
    public function getTextGroup()
    {
        return $this->textGroup;
    }

    /**
     * Set voteFor
     *
     * @param integer $voteFor
     * @return IndividualTextVoteAgregation
     */
    public function setVoteFor($voteFor)
    {
        $this->voteFor = $voteFor;

        return $this;
    }

    /**
     * Get voteFor
     *
     * @return integer 
     */
    public function getVoteFor()
    {
        return $this->voteFor;
    }

    /**
     * Set voteAgainst
     *
     * @param integer $voteAgainst
     * @return IndividualTextVoteAgregation
     */
    public function setVoteAgainst($voteAgainst)
    {
        $this->voteAgainst = $voteAgainst;

        return $this;
    }

    /**
     * Get voteAgainst
     *
     * @return integer 
     */
    public function getVoteAgainst()
    {
        return $this->voteAgainst;
    }

    /**
     * Set voteAbstention
     *
     * @param integer $voteAbstention
     * @return IndividualTextVoteAgregation
     */
    public function setVoteAbstention($voteAbstention)
    {
        $this->voteAbstention = $voteAbstention;

        return $this;
    }

    /**
     * Get voteAbstention
     *
     * @return integer 
     */
    public function getVoteAbstention()
    {
        return $this->voteAbstention;
    }
}
