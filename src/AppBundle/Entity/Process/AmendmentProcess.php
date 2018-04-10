<?php

namespace AppBundle\Entity\Process;

use Doctrine\ORM\Mapping as ORM;

/**
 * AmendmentProcess
 *
 * @ORM\Table(name="amendment_process")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Process\AmendmentProcessRepository")
 */
class AmendmentProcess
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="begin", type="datetime")
     */
    private $begin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end", type="datetime")
     */
    private $end;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Text\TextGroup", inversedBy="amendmentProcesses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $textGroup;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Process\ParticipationRule",
     *                cascade={"persist"})
     */
    private $participationRule;

    /**
     * @var \stdClass
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Text\AmendmentDeposit",
     *                mappedBy="amendmentProcess",
     *                cascade={"persist"})
     */
    private $amendmentDeposits;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isVisible", type="boolean")
     */
    private $isVisible = false;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->amendmentDeposits = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return AmendmentProcess
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
     * Set begin
     *
     * @param \DateTime $begin
     *
     * @return AmendmentProcess
     */
    public function setBegin(\DateTime $begin)
    {
        $this->begin = $begin;

        return $this;
    }

    /**
     * Get begin
     *
     * @return \DateTime
     */
    public function getBegin()
    {
        return $this->begin;
    }

    /**
     * Set end
     *
     * @param \DateTime $end
     *
     * @return AmendmentProcess
     */
    public function setEnd(\DateTime $end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get end
     *
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set textGroup
     *
     * @param \AppBundle\Entity\Text\TextGroup $textGroup
     *
     * @return AmendmentProcess
     */
    public function setTextgroup(\AppBundle\Entity\Text\TextGroup $textGroup)
    {
        $this->textGroup = $textGroup;

        return $this;
    }

    /**
     * Get textgroup
     *
     * @return \AppBundle\Entity\Text\TextGroup
     */
    public function getTextGroup()
    {
        return $this->textGroup;
    }

    /**
     * Set participationRule
     *
     * @param \AppBundle\Entity\Process\ParticipationRule $participationRule
     *
     * @return AmendmentProcess
     */
    public function setParticipationRule(\AppBundle\Entity\Process\ParticipationRule $participationRule = null)
    {
        $this->participationRule = $participationRule;

        return $this;
    }

    /**
     * Get participationRule
     *
     * @return \AppBundle\Entity\Process\ParticipationRule
     */
    public function getParticipationRule()
    {
        return $this->participationRule;
    }

    /**
     * Set isVisible
     *
     * @param boolean $isVisible
     *
     * @return AmendmentProcess
     */
    public function setIsVisible($isVisible)
    {
        $this->isVisible = $isVisible;

        return $this;
    }

    /**
     * Get isVisible
     *
     * @return boolean
     */
    public function getIsVisible()
    {
        return $this->isVisible;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return AmendmentProcess
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add amendmentDeposit
     *
     * @param \AppBundle\Entity\Text\AmendmentDeposit $amendmentDeposit
     *
     * @return AmendmentProcess
     */
    public function addAmendmentDeposit(\AppBundle\Entity\Text\AmendmentDeposit $amendmentDeposit)
    {
        $amendmentDeposit->setAmendmentProcess($this);
        $this->amendmentDeposits[] = $amendmentDeposit;

        return $this;
    }

    /**
     * Remove amendmentDeposit
     *
     * @param \AppBundle\Entity\Text\AmendmentDeposit $amendmentDeposit
     */
    public function removeAmendmentDeposit(\AppBundle\Entity\Text\AmendmentDeposit $amendmentDeposit)
    {
        $this->amendmentDeposits->removeElement($amendmentDeposit);
    }

    /**
     * Get amendmentDeposits
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAmendmentDeposits()
    {
        return $this->amendmentDeposits;
    }
}
