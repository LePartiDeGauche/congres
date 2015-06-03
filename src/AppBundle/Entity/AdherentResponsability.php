<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * AdherentResponsability.
 *
 * @ORM\Table(name="adherent_responsability")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\AdherentResponsabilityRepository")
 */
class AdherentResponsability
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
     * @ORM\ManyToOne(targetEntity="Adherent", inversedBy="responsabilities", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $adherent;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="Responsability", inversedBy="adherentResponsabilities", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $responsability;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Organ\Organ",
     * inversedBy="designatedParticipants", cascade={"persist"})
     */
    private $designatedByOrgan;

    /**
     * @var \stdClass
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Organ\OrganParticipation",
     *                inversedBy="allowedBy")
     */
    private $allowsParticipations;

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
     * @return AdherentResponsability
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
     * Set responsability.
     *
     * @param \stdClass $responsability
     *
     * @return AdherentResponsability
     */
    public function setResponsability($responsability)
    {
        $this->responsability = $responsability;

        return $this;
    }

    /**
     * Get responsability.
     *
     * @return \stdClass
     */
    public function getResponsability()
    {
        return $this->responsability;
    }

    /**
     * Set start.
     *
     * @param \DateTime $start
     *
     * @return AdherentResponsability
     */
    public function setStart($start)
    {
        $this->start = isset($start) ? $start : new DateTime();

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
     * @return AdherentResponsability
     */
    public function setEnd($end)
    {
        $this->end = isset($end) ? $end : new DateTime();

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
     * @return AdherentResponsability
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
        $this->allowsParticipations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set designatedByOrgan.
     *
     * @param \AppBundle\Entity\Organ\Organ $designatedByOrgan
     *
     * @return AdherentResponsability
     */
    public function setDesignatedByOrgan(\AppBundle\Entity\Organ\Organ $designatedByOrgan = null)
    {
        $this->designatedByOrgan = $designatedByOrgan;

        return $this;
    }

    /**
     * Get designatedByOrgan.
     *
     * @return \AppBundle\Entity\Organ\Organ
     */
    public function getDesignatedByOrgan()
    {
        return $this->designatedByOrgan;
    }

    /**
     * Add allowsParticipation.
     *
     * @param \AppBundle\Entity\Organ\OrganParticipation $allowsParticipation
     *
     * @return AdherentResponsability
     */
    public function addAllowsParticipation(\AppBundle\Entity\Organ\OrganParticipation $allowsParticipation)
    {
        $this->allowsParticipations[] = $allowsParticipation;

        return $this;
    }

    /**
     * Remove allowsParticipation.
     *
     * @param \AppBundle\Entity\Organ\OrganParticipation $allowsParticipation
     */
    public function removeAllowsParticipation(\AppBundle\Entity\Organ\OrganParticipation $allowsParticipation)
    {
        $this->allowsParticipations->removeElement($allowsParticipation);
    }

    /**
     * Get allowsParticipations.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAllowsParticipations()
    {
        return $this->allowsParticipations;
    }
}
