<?php

namespace AppBundle\Entity\Organ;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrganParticipation.
 *
 * @ORM\Table(name="organ_participation")
 * @ORM\Entity
 */
class OrganParticipation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Adherent", inversedBy="organParticipations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $adherent;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="Organ", inversedBy="participants", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $organ;

    /**
     * @var \stdClass
     * @ORM\ManyToMany(
     *                targetEntity="AppBundle\Entity\AdherentResponsability",
     *                mappedBy="allowsParticipations")
     */
    private $allowedBy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start", type="date")
     */
    private $start;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end", type="date")
     */
    private $end;

    /**
     * @var bool
     *
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive;

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
     * Set adherent.
     *
     * @param \stdClass $adherent
     *
     * @return OrganParticipation
     */
    public function setAdherent($adherent)
    {
        $this->adherent = $adherent;

        return $this;
    }

    /**
     * Get adherent.
     *
     * @return \stdClass
     */
    public function getAdherent()
    {
        return $this->adherent;
    }

    /**
     * Set organ.
     *
     * @param \stdClass $organ
     *
     * @return OrganParticipation
     */
    public function setOrgan($organ)
    {
        $this->organ = $organ;

        return $this;
    }

    /**
     * Get organ.
     *
     * @return \stdClass
     */
    public function getOrgan()
    {
        return $this->organ;
    }

    /**
     * Set start.
     *
     * @param \DateTime $start
     *
     * @return OrganParticipation
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start.
     *
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set end.
     *
     * @param \DateTime $end
     *
     * @return OrganParticipation
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get end.
     *
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set isActive.
     *
     * @param bool $isActive
     *
     * @return OrganParticipation
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive.
     *
     * @return bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->allowedBy = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add allowedBy.
     *
     * @param \AppBundle\Entity\AdherentResponsability $allowedBy
     *
     * @return OrganParticipation
     */
    public function addAllowedBy(\AppBundle\Entity\AdherentResponsability $allowedBy)
    {
        $this->allowedBy[] = $allowedBy;

        return $this;
    }

    /**
     * Remove allowedBy.
     *
     * @param \AppBundle\Entity\AdherentResponsability $allowedBy
     */
    public function removeAllowedBy(\AppBundle\Entity\AdherentResponsability $allowedBy)
    {
        $this->allowedBy->removeElement($allowedBy);
    }

    /**
     * Get allowedBy.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAllowedBy()
    {
        return $this->allowedBy;
    }

    public function __tostring()
    {
        return $this->adherent;
    }
}
