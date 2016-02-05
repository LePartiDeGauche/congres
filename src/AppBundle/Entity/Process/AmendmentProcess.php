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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Text\Amendment",
     *                mappedBy="amendmentProcess",
     *                cascade={"persist"})
     */
    private $amendments;

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
     * Constructor
     */
    public function __construct()
    {
        $this->amendments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add amendment
     *
     * @param \AppBundle\Entity\Process\Amendment $amendment
     *
     * @return AmendmentProcess
     */
    public function addAmendment(\AppBundle\Entity\Text\Amendment $amendment)
    {
        $amendment->setAmendmentProcess($this);
        $this->amendments[] = $amendment;

        return $this;
    }

    /**
     * Remove amendment
     *
     * @param \AppBundle\Entity\Process\Amendment $amendment
     */
    public function removeAmendment(\AppBundle\Entity\Text\Amendment $amendment)
    {
        $this->amendments->removeElement($amendment);
    }

    /**
     * Get amendments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAmendments()
    {
        return $this->amendments;
    }
}
