<?php

namespace AppBundle\Entity\Event;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Booking.
 *
 * @ORM\Table(name="booking")
 * @ORM\Entity
 */
class Booking
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
     * @var \AppBundle\Entity\Event\RoomType
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Event\RoomType", inversedBy="RoomType")
     * @Assert\NotNull
     */
    private $roomType;

    /**
     * @var \AppBundle\Entity\Adherent
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Adherent", inversedBy="Adherent")
     * @Assert\NotNull
     */
    private $adherent;

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
     * @return \AppBundle\Entity\Adherent
     */
    public function getAdherent()
    {
        return $this->adherent;
    }

    /**
     * @param \AppBundle\Entity\Adherent $adherent
     */
    public function setAdherent($adherent)
    {
        $this->adherent = $adherent;
    }


}