<?php

namespace AppBundle\Entity\Event;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * BedroomBooking.
 *
 * @ORM\Table(name="bedroom_booking")
 * @ORM\Entity
 */
class BedroomBooking
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
     * @var Bedroom
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Event\Bedroom", inversedBy="Bedroom")
     * @Assert\NotNull
     */
    private $bedroom;

    /**
     * @var Booking
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Event\Booking", inversedBy="Booking")
     * @Assert\NotNull
     */
    private $booking;

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
     * @return Bedroom
     */
    public function getBedroom()
    {
        return $this->bedroom;
    }

    /**
     * @param Bedroom $bedroom
     */
    public function setBedroom($bedroom)
    {
        $this->bedroom = $bedroom;
    }

    /**
     * @return Booking
     */
    public function getBooking()
    {
        return $this->booking;
    }

    /**
     * @param Booking $booking
     */
    public function setBooking($booking)
    {
        $this->booking = $booking;
    }


}