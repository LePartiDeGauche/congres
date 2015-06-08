<?php

namespace AppBundle\Entity\Event;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Sleeping.
 *
 * @ORM\Table(name="bedroom")
 * @ORM\Entity
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
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Event\RoomType", inversedBy="RoomType")
     */
    private $roomType;

    /**
     * Number or reference of the room.
     *
     * @var string
     *
     * @ORM\Column(name="name", type="text")
     */
    private $number;

    /**
     * The code or the key of the bedroom.
     *
     * @var string
     *
     * @ORM\Column(name="code_or_key", type="text")
     */
    private $codeOrKey;

    /**
     * Date of beginning
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
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id
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
     * @return string
     */
    public function getCodeOrKey()
    {
        return $this->codeOrKey;
    }

    /**
     * @param string $codeOrKey
     */
    public function setCodeOrKey($codeOrKey)
    {
        $this->codeOrKey = $codeOrKey;
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
}