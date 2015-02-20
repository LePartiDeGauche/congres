<?php

namespace AppBundle\Entity\Event;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReservationNight
 *
 * @ORM\Table(name="reservation_night")
 * @ORM\Entity
 */
class ReservationNight
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="event")
     * @ORM\ManyToOne(targetEntity="Event")
     */
    private $event;
    
    private $sleepingSites;

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
     * Set date
     *
     * @param \DateTime $date
     * @return ReservationNight
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set sleepingSite
     *
     * @param \stdClass $sleepingSite
     * @return ReservationNight
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
}
