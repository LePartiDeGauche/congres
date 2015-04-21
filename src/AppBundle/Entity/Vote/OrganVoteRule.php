<?php

namespace AppBundle\Entity\Vote;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrganVoteRule
 *
 * @ORM\Table(name="organ_voterule")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Vote\OrganVoteRuleRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="rule_type", type="string")
 * @ORM\DiscriminatorMap({})
 */
class OrganVoteRule
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
    protected $name;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Responsability")
     *
     */
    protected $reportResponsability;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Organ\OrganType")
     *
     */
    protected $concernedOrganType;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Text\TextGroup", inversedBy="organVoteRules")
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
     * Constructor
     */
    public function __construct()
    {
        $this->reportResponsability = new \Doctrine\Common\Collections\ArrayCollection();
        $this->concernedOrganType = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __tostring()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return OrganVoteRule
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add reportResponsability
     *
     * @param \AppBundle\Entity\Responsability $reportResponsability
     * @return OrganVoteRule
     */
    public function addReportResponsability(\AppBundle\Entity\Responsability $reportResponsability)
    {
        $this->reportResponsability[] = $reportResponsability;

        return $this;
    }

    /**
     * Remove reportResponsability
     *
     * @param \AppBundle\Entity\Responsability $reportResponsability
     */
    public function removeReportResponsability(\AppBundle\Entity\Responsability $reportResponsability)
    {
        $this->reportResponsability->removeElement($reportResponsability);
    }

    /**
     * Get reportResponsability
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReportResponsability()
    {
        return $this->reportResponsability;
    }

    /**
     * Add concernedOrganType
     *
     * @param \AppBundle\Entity\Organ\OrganType $concernedOrganType
     * @return OrganVoteRule
     */
    public function addConcernedOrganType(\AppBundle\Entity\Organ\OrganType $concernedOrganType)
    {
        $this->concernedOrganType[] = $concernedOrganType;

        return $this;
    }

    /**
     * Remove concernedOrganType
     *
     * @param \AppBundle\Entity\Organ\OrganType $concernedOrganType
     */
    public function removeConcernedOrganType(\AppBundle\Entity\Organ\OrganType $concernedOrganType)
    {
        $this->concernedOrganType->removeElement($concernedOrganType);
    }

    /**
     * Get concernedOrganType
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getConcernedOrganType()
    {
        return $this->concernedOrganType;
    }

    /**
     * Set textGroup
     *
     * @param \AppBundle\Entity\Text\TextGroup $textGroup
     * @return OrganVoteRule
     */
    public function setTextGroup(\AppBundle\Entity\Text\TextGroup $textGroup)
    {
        $this->textGroup = $textGroup;

        return $this;
    }

    /**
     * Get textGroup
     *
     * @return \AppBundle\Entity\Text\TextGroup 
     */
    public function getTextGroup()
    {
        return $this->textGroup;
    }
}
