<?php

namespace AppBundle\Entity\Vote;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Text\Text;
use AppBundle\Entity\Text\TextGroup;

/**
 *
 * AppBundle\Entity\Vote\TextVoteAgregation
 *
 * @ORM\MappedSuperclass
 *
 */
abstract class TextVoteAgregation
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Text\Text", inversedBy="individualVoteAgregations")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    protected $text;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Text\TextGroup")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    protected $textGroup;

    /**
     * @var integer
     *
     * @ORM\Column(name="voteFor", type="integer")
     */
    protected $voteFor;

    /**
     * @var integer
     *
     * @ORM\Column(name="voteAgainst", type="integer")
     */
    protected $voteAgainst;

    /**
     * @var integer
     *
     * @ORM\Column(name="voteAbstention", type="integer")
     */
    protected $voteAbstention;

    public function __construct(Text $text, TextGroup $textGroup)
    {
        $this->text = $text;
        $this->textGroup = $textGroup;
        $this->voteFor = 0;
        $this->voteAgainst = 0;
        $this->voteAbstention = 0;
    }
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

?>
