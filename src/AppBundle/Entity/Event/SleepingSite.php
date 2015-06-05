<?php

namespace AppBundle\Entity\Event;

use Doctrine\ORM\Mapping as ORM;

/**
 * SleepingSite.
 *
 * @ORM\Table(name="sleeping_site")
 * @ORM\Entity
 */
class SleepingSite
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
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var int
     *
     * @ORM\Column(name="number_places", type="integer")
     */
    private $numberOfPlaces;

    /**
     * @var string
     *
     * @ORM\Column(name="position_description", type="text")
     */
    private $positionDescription;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;


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
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return SleepingSite
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return SleepingSite
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
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
     * @return int
     */
    public function getNumberOfPlaces()
    {
        return $this->numberOfPlaces;
    }

    /**
     * @param int $numberOfPlaces
     */
    public function setNumberOfPlaces($numberOfPlaces)
    {
        $this->numberOfPlaces = $numberOfPlaces;
    }

    /**
     * @return string
     */
    public function getPositionDescription()
    {
        return $this->positionDescription;
    }

    /**
     * @param string $positionDescription
     */
    public function setPositionDescription($positionDescription)
    {
        $this->positionDescription = $positionDescription;
    }

    /**
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }
}
