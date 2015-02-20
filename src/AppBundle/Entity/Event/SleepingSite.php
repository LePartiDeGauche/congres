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
     * @ORM\Column(name="sleeping_facility")
     * @ORM\ManyToOne(targetEntity="SleepingFacility")
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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Event\ReservationNight", inversedBy="sleepingSites")
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
}
