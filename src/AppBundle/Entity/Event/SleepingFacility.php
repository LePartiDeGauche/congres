<?php

namespace AppBundle\Entity\Event;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Address;

/**
 * SleepingFacility.
 *
 * @ORM\Table(name="sleeping_facility")
 * @ORM\Entity
 */
class SleepingFacility
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
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="sleepingFacilities")
     * @ORM\JoinColumn(nullable=false)
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
     * @var integer
     *
     * @ORM\Column(name="reservation_nights", type="integer")
     */
    private $reservationNights;

    /**
     * @var string
     *
     * @ORM\Column(name="comments", type="text")
     */
    private $comments;

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
     * Get event.
     *
     * @return string
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set event.
     *
     * @param string $event
     *
     * @return SleepingFacility
     */
    public function setEvent($event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * @return \stdClass
     */
    public function getSleepingSites()
    {
        return $this->sleepingSites;
    }

    /**
     * @param \stdClass $sleepingSites
     */
    public function setSleepingSites($sleepingSites)
    {
        $this->sleepingSites = $sleepingSites;
    }

    /**
     * @return int
     */
    public function getReservationNights()
    {
        return $this->reservationNights;
    }

    /**
     * @param int $reservationNights
     */
    public function setReservationNights($reservationNights)
    {
        $this->reservationNights = $reservationNights;
    }

    /**
     * @return string
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param string $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }
}
