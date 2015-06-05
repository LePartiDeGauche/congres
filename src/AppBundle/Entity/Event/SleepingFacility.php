<?php

namespace AppBundle\Entity\Event;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * The Event concerned.
     *
     * @var \AppBundle\Entity\Event\Event
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Event\Event", inversedBy="Event")
     */
    private $event;

    /**
     * The Sleeping Site.
     *
     * @var \AppBundle\Entity\Event\SleepingSite
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Event\SleepingSite", inversedBy="SleepingSite")
     */
    private $sleepingSite;

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
     * @return Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param Event $event
     */
    public function setEvent(Event $event)
    {
        $this->event = $event;
    }

    /**
     * @return SleepingSite
     */
    public function getSleepingSite()
    {
        return $this->sleepingSite;
    }

    /**
     * @param SleepingSite $sleepingSite
     */
    public function setSleepingSite(SleepingSite $sleepingSite)
    {
        $this->sleepingSite = $sleepingSite;
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
