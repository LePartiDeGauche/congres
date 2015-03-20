<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdherentResponsability
 *
 * @ORM\Table(name="adherent_responsability")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\AdherentResponsabilityRepository")
 */
class AdherentResponsability
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
     * @ORM\ManyToOne(targetEntity="Adherent", inversedBy="responsabilities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $adherent;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="Responsability", inversedBy="adherentResponsabilities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $responsability;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Organ\Organ",
     * inversedBy="designatedParticipants")
     */
    private $designatedByOrgan;

    /**
     * @var \stdClass
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Organ\OrganParticipation", 
     * inversedBy="allowedBy")
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
     * @var boolean
     *
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive;


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
     * Set adherent
     *
     * @param \stdClass $adherent
     * @return AdherentResponsability
     */
    public function setAdherent($adherent)
    {
        $this->adherent = $adherent;

        return $this;
    }

    /**
     * Get adherent
     *
     * @return \stdClass 
     */
    public function getAdherent()
    {
        return $this->adherent;
    }

    /**
     * Set responsability
     *
     * @param \stdClass $responsability
     * @return AdherentResponsability
     */
    public function setResponsability($responsability)
    {
        $this->responsability = $responsability;

        return $this;
    }

    /**
     * Get responsability
     *
     * @return \stdClass 
     */
    public function getResponsability()
    {
        return $this->responsability;
    }

    /**
     * Set start
     *
     * @param \DateTime $start
     * @return AdherentResponsability
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return \DateTime 
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set end
     *
     * @param \DateTime $end
     * @return AdherentResponsability
     */
    public function setEnd($end)
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
     * Set isActive
     *
     * @param boolean $isActive
     * @return AdherentResponsability
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
}
