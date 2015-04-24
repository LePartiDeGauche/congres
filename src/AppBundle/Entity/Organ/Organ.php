<?php

namespace AppBundle\Entity\Organ;

use Doctrine\ORM\Mapping as ORM;

/**
 * Organ
 *
 * @ORM\Table(name="organ")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Organ\OrganRepository")
 */
class Organ
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
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="OrganType", inversedBy="organs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $organType;


    /**
     * @var \stdClass
     * parents organ on the hierarchie.
     * example : a "comité" parent is commission départementale
     * @ORM\ManyToMany(targetEntity="Organ", 
     * inversedBy="subOrgans")
     */
    private $parentOrgans;   


    /**
     * @var \stdClass
     * attached sub organs on the hierarchy.
     * example : several "comité" are attache to a commission départementale
     * example : Commité is attached To Comité Départementale
     * @ORM\ManyToMany(targetEntity="Organ", 
     * mappedBy="parentOrgans")
     */
    private $subOrgans;

    /**
     * @var \stdClass
     *
     * @ORM\OneToMany(targetEntity="OrganParticipation", mappedBy="organ",
     * cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $participants;

    /**
     * @var \stdClass
     *
     *  @ORM\OneToMany(targetEntity="AppBundle\Entity\Vote\IndividualOrganTextVote",
     *  mappedBy="organ")
     *  
     */
    private $textVoteReports;

    /**
     * @var \stdClass
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AdherentResponsability", mappedBy="designatedByOrgan",
     * cascade={"persist", "remove", "merge"})
     */
    private $designatedParticipants;

    public function __tostring()
    {
        return $this->name;
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
     * @return Organ
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
     * Set description
     *
     * @param string $description
     * @return Organ
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
     * Set organType
     *
     * @param \stdClass $organType
     * @return Organ
     */
    public function setOrganType($organType)
    {
        $this->organType = $organType;

        return $this;
    }

    /**
     * Get organType
     *
     * @return \stdClass 
     */
    public function getOrganType()
    {
        return $this->organType;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->parentOrgans = new \Doctrine\Common\Collections\ArrayCollection();
        $this->subOrgans = new \Doctrine\Common\Collections\ArrayCollection();
        $this->participants = new \Doctrine\Common\Collections\ArrayCollection();
        $this->designatedParticipants = new \Doctrine\Common\Collections\ArrayCollection();
        $this->textVoteReports = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add parentOrgans
     *
     * @param \AppBundle\Entity\Organ\Organ $parentOrgans
     * @return Organ
     */
    public function addParentOrgan(\AppBundle\Entity\Organ\Organ $parentOrgans)
    {
        $this->parentOrgans[] = $parentOrgans;

        return $this;
    }

    /**
     * Remove parentOrgans
     *
     * @param \AppBundle\Entity\Organ\Organ $parentOrgans
     */
    public function removeParentOrgan(\AppBundle\Entity\Organ\Organ $parentOrgans)
    {
        $this->parentOrgans->removeElement($parentOrgans);
    }

    /**
     * Get parentOrgans
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getParentOrgans()
    {
        return $this->parentOrgans;
    }

    /**
     * Add subOrgans
     *
     * @param \AppBundle\Entity\Organ\Organ $subOrgans
     * @return Organ
     */
    public function addSubOrgan(\AppBundle\Entity\Organ\Organ $subOrgans)
    {
        $this->subOrgans[] = $subOrgans;

        return $this;
    }

    /**
     * Remove subOrgans
     *
     * @param \AppBundle\Entity\Organ\Organ $subOrgans
     */
    public function removeSubOrgan(\AppBundle\Entity\Organ\Organ $subOrgans)
    {
        $this->subOrgans->removeElement($subOrgans);
    }

    /**
     * Get subOrgans
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSubOrgans()
    {
        return $this->subOrgans;
    }

    /**
     * Add participants
     *
     * @param \AppBundle\Entity\Organ\OrganParticipation $participants
     * @return Organ
     */
    public function addParticipant(\AppBundle\Entity\Organ\OrganParticipation $participants)
    {
        $this->participants[] = $participants;

        return $this;
    }

    /**
     * Remove participants
     *
     * @param \AppBundle\Entity\Organ\OrganParticipation $participants
     */
    public function removeParticipant(\AppBundle\Entity\Organ\OrganParticipation $participants)
    {
        $this->participants->removeElement($participants);
    }

    /**
     * Get participants
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * Add designatedParticipants
     *
     * @param \AppBundle\Entity\AdherentResponsability $designatedParticipants
     * @return Organ
     */
    public function addDesignatedParticipant(\AppBundle\Entity\AdherentResponsability $designatedParticipants)
    {
        $this->designatedParticipants[] = $designatedParticipants;

        return $this;
    }

    /**
     * Remove designatedParticipants
     *
     * @param \AppBundle\Entity\AdherentResponsability $designatedParticipants
     */
    public function removeDesignatedParticipant(\AppBundle\Entity\AdherentResponsability $designatedParticipants)
    {
        $this->designatedParticipants->removeElement($designatedParticipants);
    }

    /**
     * Get designatedParticipants
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDesignatedParticipants()
    {
        return $this->designatedParticipants;
    }

    /**
     * Add textVoteReport
     *
     * @param \AppBundle\Entity\Vote\IndividualOrganTextVote $textVoteReport
     *
     * @return Organ
     */
    public function addTextVoteReport(\AppBundle\Entity\Vote\IndividualOrganTextVote $textVoteReport)
    {
        $this->textVoteReports[] = $textVoteReport;

        return $this;
    }

    /**
     * Remove textVoteReport
     *
     * @param \AppBundle\Entity\Vote\IndividualOrganTextVote $textVoteReport
     */
    public function removeTextVoteReport(\AppBundle\Entity\Vote\IndividualOrganTextVote $textVoteReport)
    {
        $this->textVoteReports->removeElement($textVoteReport);
    }

    /**
     * Get textVoteReports
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTextVoteReports()
    {
        return $this->textVoteReports;
    }
}
