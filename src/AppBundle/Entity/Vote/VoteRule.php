<?php

namespace AppBundle\Entity\Vote;

use Doctrine\ORM\Mapping as ORM;

/**
 * VoteRule
 *
 * @ORM\Table(name="vote_rule")
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="rule_type", type="string")
 * @ORM\DiscriminatorMap({"threshold" = "ThresholdVoteRule"})
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
     * @ORM\Column(type="string", length=255)
     *
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Responsability")
     *
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
