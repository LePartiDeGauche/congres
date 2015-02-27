<?php

namespace AppBundle\Entity\Event;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Address;

/**
 * SleepingFacility
 *
 * @ORM\Table(name="sleeping_facility")
 * @ORM\Entity
 */
class SleepingFacility
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
     * @ORM\Column(name="event")
     * @ORM\ManyToOne(targetEntity="Event")
     */
    private $event;

    /**
     * @var \stdClass
     *
     * @ORM\OneToMany(targetEntity="SleepingSite", mappedBy="sleepingFacility",
     * cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $sleepingSites;

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
     * @var string
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Address",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="positionDescription", type="text")
     */
    private $positionDescription;


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
     * Set sleepingSite
     *
     * @param \stdClass $sleepingSite
     * @return SleepingFacility
     */
    public function setSleepingSite($sleepingSite)
    {
        $this->sleepingSite = $sleepingSite;

        return $this;
    }

    /**
     * Get sleepingSite
     *
     * @return \stdClass 
     */
    public function getSleepingSite()
    {
        return $this->sleepingSite;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return SleepingFacility
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
     * @return SleepingFacility
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
     * Set address
     *
     * @param string $address
     * @return SleepingFacility
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set positionDescription
     *
     * @param string $positionDescription
     * @return SleepingFacility
     */
    public function setPositionDescription($positionDescription)
    {
        $this->positionDescription = $positionDescription;

        return $this;
    }

    /**
     * Get positionDescription
     *
     * @return string 
     */
    public function getPositionDescription()
    {
        return $this->positionDescription;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sleepingSites = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set event
     *
     * @param string $event
     * @return SleepingFacility
     */
    public function setEvent($event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return string 
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Add sleepingSites
     *
     * @param \AppBundle\Entity\Event\SleepingSite $sleepingSites
     * @return SleepingFacility
     */
    public function addSleepingSite(\AppBundle\Entity\Event\SleepingSite $sleepingSites)
    {
        $this->sleepingSites[] = $sleepingSites;

        return $this;
    }

    /**
     * Remove sleepingSites
     *
     * @param \AppBundle\Entity\Event\SleepingSite $sleepingSites
     */
    public function removeSleepingSite(\AppBundle\Entity\Event\SleepingSite $sleepingSites)
    {
        $this->sleepingSites->removeElement($sleepingSites);
    }

    /**
     * Get sleepingSites
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSleepingSites()
    {
        return $this->sleepingSites;
    }
}
