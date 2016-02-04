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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Text\TextGroup", inversedBy="amendmentprocesses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $textgroup;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Process\ParticipationRule",
     *                cascade={"persist"})
     */
    private $participationRule;

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
     * Set textgroup
     *
     * @param \AppBundle\Entity\Text\TextGroup $textgroup
     *
     * @return AmendmentProcess
     */
    public function setTextgroup(\AppBundle\Entity\Text\TextGroup $textgroup)
    {
        $this->textgroup = $textgroup;

        return $this;
    }

    /**
     * Get textgroup
     *
     * @return \AppBundle\Entity\Text\TextGroup
     */
    public function getTextgroup()
    {
        return $this->textgroup;
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
}
