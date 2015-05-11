<?php

namespace AppBundle\Entity\Vote;

use Doctrine\ORM\Mapping as ORM;

/**
 * VoteRule.
 *
 * @ORM\Table(name="vote_rule")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Vote\VoteRuleRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="rule_type", type="string")
 * @ORM\DiscriminatorMap({"threshold" = "ThresholdVoteRule"})
 */
abstract class VoteRule
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Responsability")
     */
    protected $concernedResponsability;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Text\TextGroup", inversedBy="voteRules")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $textGroup;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set concernedResponsability.
     *
     * @param \stdClass $concernedResponsability
     *
     * @return VoteRule
     */
    public function setConcernedResponsability($concernedResponsability)
    {
        $this->concernedResponsability = $concernedResponsability;

        return $this;
    }

    /**
     * Get concernedResponsability.
     *
     * @return \stdClass
     */
    public function getConcernedResponsability()
    {
        return $this->concernedResponsability;
    }
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->concernedResponsability = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return VoteRule
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add concernedResponsability.
     *
     * @param \AppBundle\Entity\Responsability $concernedResponsability
     *
     * @return VoteRule
     */
    public function addConcernedResponsability(\AppBundle\Entity\Responsability $concernedResponsability)
    {
        $this->concernedResponsability[] = $concernedResponsability;

        return $this;
    }

    /**
     * Remove concernedResponsability.
     *
     * @param \AppBundle\Entity\Responsability $concernedResponsability
     */
    public function removeConcernedResponsability(\AppBundle\Entity\Responsability $concernedResponsability)
    {
        $this->concernedResponsability->removeElement($concernedResponsability);
    }

    /**
     * Set textGroup.
     *
     * @param \AppBundle\Entity\Text\TextGroup $textGroup
     *
     * @return VoteRule
     */
    public function setTextGroup(\AppBundle\Entity\Text\TextGroup $textGroup)
    {
        $this->textGroup = $textGroup;

        return $this;
    }

    /**
     * Get textGroup.
     *
     * @return \AppBundle\Entity\Text\TextGroup
     */
    public function getTextGroup()
    {
        return $this->textGroup;
    }

    public function __toString()
    {
        return $this->name;
    }
}
