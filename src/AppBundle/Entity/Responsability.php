<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Instance.
 *
 * @ORM\Table(name="instances",
 * indexes ={@ORM\Index(name="name", columns={"name"})})
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ResponsabilityRepository")
 */
class Responsability
{
    const INSTANCE_CN = 'Conseil National';
    const INSTANCE_BN = 'Bureau National';
    const INSTANCE_SN = 'Secrétariat National';
    const INSTANCE_COSEC = 'Co-secrétaire de comité';
    const INSTANCE_DEL = 'Délégué au congrés';
    const INSTANCE_BC = 'Bureau du Congrès';
    const INSTANCE_CDC = 'Commission de candidatures';
    const INSTANCE_SEN = 'Secrétariat exécutif national';
    const INSTANCE_CRC = 'Commission de résolution des conflits';
    const INSTANCE_CCF = 'Commission de contrôle financier';
    const INSTANCE_CN_NAT = 'Conseil national - part nationale';
    const INSTANCE_COSEC_DEPARTMENT = 'Co-secrétaire de département';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="date", type="date", nullable=true)
     */
    private $electionDate;

    /**
     * The collection of user members of the instance.
     *
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AdherentResponsability", mappedBy="responsability", orphanRemoval=true)
     */
    private $adherentResponsabilities;

    /**
     * The collection of user members of the instance.
     *
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Organ\OrganType",
     * inversedBy="participationAllowedBy")
     */
    private $allowsParticipations;

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
     * Set name.
     *
     * @param string $name
     *
     * @return Instance
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
     * Constructor.
     */
    public function __construct()
    {
        $this->adherents = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add adherents.
     *
     * @param \AppBundle\Entity\Adherent $adherent
     *
     * @return Instance
     */
    public function addAdherent(\AppBundle\Entity\Adherent $adherent)
    {
        $this->adherents->add($adherent);

        return $this;
    }

    /**
     * Remove adherents.
     *
     * @param \AppBundle\Entity\Adherent $adherents
     */
    public function removeAdherent(\AppBundle\Entity\Adherent $adherent)
    {
        $this->adherents->removeElement($adherent);
    }

    /**
     * Get adherents.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdherents()
    {
        return $this->adherents;
    }

    /**
     * Set election date.
     *
     * @param \DateTime $date
     *
     * @return Instance
     */
    public function setElectionDate(\DateTime $date)
    {
        $this->electionDate = $date;

        return $this;
    }

    /**
     * Get election date.
     *
     * @return \DateTime
     */
    public function getElectionDate()
    {
        return $this->electionDate;
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * Add adherentResponsability.
     *
     * @param \AppBundle\Entity\AdherentResponsability $adherentResponsability
     *
     * @return Responsability
     */
    public function addAdherentResponsability(\AppBundle\Entity\AdherentResponsability $adherentResponsability)
    {
        $this->adherentResponsabilities[] = $adherentResponsability;

        return $this;
    }

    /**
     * Remove adherentResponsability.
     *
     * @param \AppBundle\Entity\AdherentResponsability $adherentResponsability
     */
    public function removeAdherentResponsability(\AppBundle\Entity\AdherentResponsability $adherentResponsability)
    {
        $this->adherentResponsabilities->removeElement($adherentResponsability);
    }

    /**
     * Get adherentResponsabilities.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdherentResponsabilities()
    {
        return $this->adherentResponsabilities;
    }

    /**
     * Add allowsParticipation.
     *
     * @param \AppBundle\Entity\Organ\OrganType $allowsParticipation
     *
     * @return Responsability
     */
    public function addAllowsParticipation(\AppBundle\Entity\Organ\OrganType $allowsParticipation)
    {
        $this->allowsParticipations[] = $allowsParticipation;

        return $this;
    }

    /**
     * Remove allowsParticipation.
     *
     * @param \AppBundle\Entity\Organ\OrganType $allowsParticipation
     */
    public function removeAllowsParticipation(\AppBundle\Entity\Organ\OrganType $allowsParticipation)
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
