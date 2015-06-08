<?php

namespace AppBundle\Entity\Event;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * RoomType.
 *
 * @ORM\Table(name="room_type")
 * @ORM\Entity
 */
class RoomType
{
    const ROOM_SINGLE = 'Chambre simple';
    const ROOM_TWIN = 'Twin : 2 lits séparés';
    const ROOM_DOUBLE = 'Chambre double';
    const ROOM_OTHER = 'Autre';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * The SleepingSite concerned.
     *
     * @var SleepingSite
     *
     * @ORM\ManyToOne(targetEntity="SleepingSite", inversedBy="roomTypes", cascade="persist")
     */
    private $sleepingSite;

    /**
     * Name.
     *
     * @var string
     *
     * @ORM\Column(name="name", type="text")
     */
    private $name;

    /**
     * Type.
     *
     * @var string
     *
     * @ORM\Column(name="type", type="text")
     */
    private $type;

    /**
     * Short Description.
     *
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * Number of places.
     *
     * @var integer
     *
     * @ORM\Column(name="places", type="integer")
     * @Assert\NotNull
     */
    private $places;

    /**
     * Is available.
     *
     * @var int
     *
     * @ORM\Column(name="available", type="integer")
     * @Assert\NotNull
     */
    private $available;

    /**
     * Price.
     *
     * @var int
     *
     * @ORM\Column(name="price", type="integer")
     * @Assert\NotNull
     */
    private $price;

    /**
     * Can this place book more than the number of places.
     *
     * @var bool
     *
     * @ORM\Column(name="can_book_more", type="boolean", nullable=true)
     */
    private $canBookMore;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Constructor.
     */
    public function __construct()
    {
        // Initialize collection
        $this->sleepingSite = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
    public function setSleepingSite($sleepingSite)
    {
        $this->sleepingSite = $sleepingSite;
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
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
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
     * @return int
     */
    public function getPlaces()
    {
        return $this->places;
    }

    /**
     * @param int $places
     */
    public function setPlaces($places)
    {
        $this->places = $places;
    }

    /**
     * @return int
     */
    public function getAvailable()
    {
        return $this->available;
    }

    /**
     * @param int $available
     */
    public function setAvailable($available)
    {
        $this->available = $available;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return boolean
     */
    public function isCanBookMore()
    {
        return $this->canBookMore;
    }

    /**
     * @param boolean $canBookMore
     */
    public function setCanBookMore($canBookMore)
    {
        $this->canBookMore = $canBookMore;
    }

    public function __toString()
    {
        return $this->name;
    }
}
