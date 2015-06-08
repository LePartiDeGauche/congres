<?php

namespace AppBundle\Entity\Event;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SleepingSite.
 *
 * @ORM\Table(name="sleeping_site")
 * @ORM\Entity
 */
class SleepingSite
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
     * Name of the place. Hostel or the house of a party's member.
     *
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotNull
     */
    private $name;

    /**
     * The Event concerned.
     *
     * @var \AppBundle\Entity\Event\Event
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Event\Event", inversedBy="Event")
     * @Assert\NotNull
     */
    private $event;

    /**
     * Short Description.
     *
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * Address.
     *
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * Latitude of the place.
     *
     * @var float
     *
     * @ORM\Column(name="latitude", type="float", nullable=true)
     */
    private $latitude;

    /**
     * Longitude of the place.
     *
     * @var float
     *
     * @ORM\Column(name="longitude", type="float", nullable=true)
     */
    private $longitude;

    /**
     * @var RoomType[]
     *
     * @ORM\OneToMany(targetEntity="RoomType", mappedBy="sleepingSite")
     */
    private $roomTypes;

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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param Event $event
     */
    public function setEvent($event)
    {
        $this->event = $event;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return RoomType[]
     */
    public function getRoomTypes()
    {
        return $this->roomTypes;
    }

    /**
     * @param RoomType[] $roomTypes
     */
    public function setRoomTypes($roomTypes)
    {
        $this->roomTypes = $roomTypes;
    }


    /**
     * Add roomTypes.
     *
     * @param \AppBundle\Entity\Event\RoomType $roomTypes
     *
     * @return RoomType
     */
    public function addRoomType(\AppBundle\Entity\Event\RoomType $roomType)
    {
        if ($roomType->getSleepingSite() === null) {
            $roomType->setSleepingSite($this);
        }
        $this->roomTypes[] = $roomType;

        return $this;
    }

    /**
     * Remove roomTypes.
     *
     * @param \AppBundle\Entity\Event\RoomType $roomTypes
     */
    public function removeRoomType(\AppBundle\Entity\Event\RoomType $roomTypes)
    {
        $this->roomTypes->removeElement($roomTypes);
    }

}
