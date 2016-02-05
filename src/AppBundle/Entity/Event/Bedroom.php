<?php

namespace AppBundle\Entity\Event;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sleeping.
 *
 * @ORM\Table(name="bedroom")
 * @ORM\Entity(repositoryClass="BedroomRepository")
 */
class Bedroom
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
     * @var \Doctrine\Common\Collections\Collection
     * @var RoomType
     *
     * @ORM\ManyToOne(targetEntity="RoomType", inversedBy="bedrooms", cascade="persist")
     */
    private $roomType;

    /**
     * Number or reference of the room.
     *
     * @var string
     *
     * @ORM\Column(name="number", type="text")
     */
    private $number;

    /**
     * Date of beginning.
     *
     * @var datetime
     *
     * @ORM\Column(name="date_start_availability", type="datetime")
     */
    private $dateStartAvailability;

    /**
     * Date of end.
     *
     * @var datetime
     *
     * @ORM\Column(name="date_stop_availability", type="datetime")
     */
    private $dateStopAvailability;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return RoomType
     */
    public function getRoomType()
    {
        return $this->roomType;
    }

    /**
     * @param RoomType $roomType
     */
    public function setRoomType($roomType)
    {
        $this->roomType = $roomType;
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param string $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return datetime
     */
    public function getDateStartAvailability()
    {
        return $this->dateStartAvailability;
    }

    /**
     * @param datetime $dateStartAvailability
     */
    public function setDateStartAvailability($dateStartAvailability)
    {
        $this->dateStartAvailability = $dateStartAvailability;
    }

    /**
     * @return datetime
     */
    public function getDateStopAvailability()
    {
        return $this->dateStopAvailability;
    }

    /**
     * @param datetime $dateStopAvailability
     */
    public function setDateStopAvailability($dateStopAvailability)
    {
        $this->dateStopAvailability = $dateStopAvailability;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $sleepingSite = $this->getRoomType()->getSleepingSite();
        $number = $this->getNumber();

        return $sleepingSite.', chambre : '.$number;
    }
}
