<?php

namespace AppBundle\Entity\Vote;

use Doctrine\ORM\Mapping as ORM;

/**
 * VoteRule
 *
 * @ORM\Table(name="vote_rule")
 * @ORM\Entity
 */
class VoteRule
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
     * @ORM\Column(name="concernedResponsability", type="object")
     */
    private $concernedResponsability;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Text\TextGroup", inversedBy="voteRules")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $textGroup;


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
     * Set concernedResponsability
     *
     * @param \stdClass $concernedResponsability
     * @return VoteRule
     */
    public function setConcernedResponsability($concernedResponsability)
    {
        $this->concernedResponsability = $concernedResponsability;

        return $this;
    }

    /**
     * Get concernedResponsability
     *
     * @return \stdClass 
     */
    public function getConcernedResponsability()
    {
        return $this->concernedResponsability;
    }
}
