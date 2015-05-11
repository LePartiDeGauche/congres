<?php

namespace AppBundle\Entity\Event;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReservationNight.
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
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="reservationNights")
     * @ORM\JoinColumn(name="event")
     */
    private $event;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToMany(targetEntity="SleepingSite",
     * inversedBy="reservationNights")
     */
    private $sleepingSites;

    /**
     * Get id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return ReservationNight
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set sleepingSite.
     *
     * @param \stdClass $sleepingSite
     *
     * @return ReservationNight
     */
    public function setSleepingSite($sleepingSite)
    {
        $this->sleepingSite = $sleepingSite;

        return $this;
    }

    /**
     * Get sleepingSite.
     *
     * @return \stdClass
     */
    public function getSleepingSite()
    {
        return $this->sleepingSite;
    }
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->sleepingSites = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set event.
     *
     * @param \AppBundle\Entity\Event\Event $event
     *
     * @return ReservationNight
     */
    public function setEvent(\AppBundle\Entity\Event\Event $event = null)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event.
     *
     * @return \AppBundle\Entity\Event\Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Add sleepingSites.
     *
     * @param \AppBundle\Entity\Event\SleepingSite $sleepingSites
     *
     * @return ReservationNight
     */
    public function addSleepingSite(\AppBundle\Entity\Event\SleepingSite $sleepingSites)
    {
        $this->sleepingSites[] = $sleepingSites;

        return $this;
    }

    /**
     * Remove sleepingSites.
     *
     * @param \AppBundle\Entity\Event\SleepingSite $sleepingSites
     */
    public function removeSleepingSite(\AppBundle\Entity\Event\SleepingSite $sleepingSites)
    {
        $this->sleepingSites->removeElement($sleepingSites);
    }

    /**
     * Get sleepingSites.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSleepingSites()
    {
        return $this->sleepingSites;
    }
}
