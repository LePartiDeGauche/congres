<?php

namespace AppBundle\Entity\Event;

use Doctrine\ORM\Mapping as ORM;

/**
 * SleepingSite
 *
 * @ORM\Table(name="sleeping_site")
 * @ORM\Entity
 */
class SleepingSite
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
     * @ORM\ManyToOne(targetEntity="SleepingFacility", inversedBy="sleepingSites")
     * @ORM\JoinColumn(name="sleeping_facility", nullable=false)
     */
    private $sleepingFacility;

    /**
     * @var \stdClass
     *
     * @ORM\OneToMany(targetEntity="SleepingSpot", mappedBy="sleepingSite",
      * cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    
    private $sleepingSpots;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Event\ReservationNight", mappedBy="sleepingSites")
     * 
     *
     */
    private $reservationNights;


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
     * @return SleepingSite
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
     * @return SleepingSite
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
     * Set beds
     *
     * @param \stdClass $beds
     * @return SleepingSite
     */
    public function setBeds($beds)
    {
        $this->beds = $beds;

        return $this;
    }

    /**
     * Get beds
     *
     * @return \stdClass 
     */
    public function getBeds()
    {
        return $this->beds;
    }

    /**
     * Set bedsNight
     *
     * @param \stdClass $bedsNight
     * @return SleepingSite
     */
    public function setBedsNight($bedsNight)
    {
        $this->bedsNight = $bedsNight;

        return $this;
    }

    /**
     * Get bedsNight
     *
     * @return \stdClass 
     */
    public function getBedsNight()
    {
        return $this->bedsNight;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sleepingSpots = new \Doctrine\Common\Collections\ArrayCollection();
        $this->reservationNights = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set sleepingFacility
     *
     * @param \AppBundle\Entity\Event\SleepingFacility $sleepingFacility
     * @return SleepingSite
     */
    public function setSleepingFacility(\AppBundle\Entity\Event\SleepingFacility $sleepingFacility)
    {
        $this->sleepingFacility = $sleepingFacility;

        return $this;
    }

    /**
     * Get sleepingFacility
     *
     * @return \AppBundle\Entity\Event\SleepingFacility 
     */
    public function getSleepingFacility()
    {
        return $this->sleepingFacility;
    }

    /**
     * Add sleepingSpots
     *
     * @param \AppBundle\Entity\Event\SleepingSpot $sleepingSpots
     * @return SleepingSite
     */
    public function addSleepingSpot(\AppBundle\Entity\Event\SleepingSpot $sleepingSpots)
    {
        $this->sleepingSpots[] = $sleepingSpots;

        return $this;
    }

    /**
     * Remove sleepingSpots
     *
     * @param \AppBundle\Entity\Event\SleepingSpot $sleepingSpots
     */
    public function removeSleepingSpot(\AppBundle\Entity\Event\SleepingSpot $sleepingSpots)
    {
        $this->sleepingSpots->removeElement($sleepingSpots);
    }

    /**
     * Get sleepingSpots
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSleepingSpots()
    {
        return $this->sleepingSpots;
    }

    /**
     * Add reservationNights
     *
     * @param \AppBundle\Entity\Event\ReservationNight $reservationNights
     * @return SleepingSite
     */
    public function addReservationNight(\AppBundle\Entity\Event\ReservationNight $reservationNights)
    {
        $this->reservationNights[] = $reservationNights;

        return $this;
    }

    /**
     * Remove reservationNights
     *
     * @param \AppBundle\Entity\Event\ReservationNight $reservationNights
     */
    public function removeReservationNight(\AppBundle\Entity\Event\ReservationNight $reservationNights)
    {
        $this->reservationNights->removeElement($reservationNights);
    }

    /**
     * Get reservationNights
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReservationNights()
    {
        return $this->reservationNights;
    }
}
