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

    const PRICE_MIN = 10;
    const PRICE_MED = 15;
    const PRICE_HIGH = 20;
    const PRICE_MAX = 25;

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
     * @var int
     *
     * @ORM\Column(name="places", type="integer")
     * @Assert\NotNull
     */
    private $places;

    /**
     * Can this place book more than the number of places.
     *
     * @var bool
     *
     * @ORM\Column(name="can_book_more", type="boolean", nullable=true)
     */
    private $canBookMore;

    /**
     * @var Bedroom[]
     *
     * @ORM\OneToMany(targetEntity="Bedroom", mappedBy="roomType")
     */
    private $bedrooms;

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
     * @return Bedroom[]
     */
    public function getBedrooms()
    {
        return $this->bedrooms;
    }

    /**
     * @param Bedroom[] $bedrooms
     */
    public function setBedrooms($bedrooms)
    {
        $this->bedrooms = $bedrooms;
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
     * @return bool
     */
    public function isCanBookMore()
    {
        return $this->canBookMore;
    }

    /**
     * @param bool $canBookMore
     */
    public function setCanBookMore($canBookMore)
    {
        $this->canBookMore = $canBookMore;
    }

    public function __toString()
    {
        return $this->name;
    }
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Initialize collection
        $this->bedRooms = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add bedrooms.
     *
     * @param Bedroom $bedroom
     *
     * @return Bedroom
     *
     * @internal param Bedroom $bedrooms
     */
    public function addBedroom(Bedroom $bedroom)
    {
        if ($bedroom->getSleepingSite() === null) {
            $bedroom->setSleepingSite($this);
        }
        $this->bedrooms[] = $bedroom;

        return $this;
    }

    /**
     * Remove roomTypes.
     *
     * @param Bedroom $bedrooms
     *
     * @internal param Bedroom $bedrooms
     */
    public function removeBedroom(Bedroom $bedrooms)
    {
        $this->bedrooms->removeElement($bedrooms);
    }
}
