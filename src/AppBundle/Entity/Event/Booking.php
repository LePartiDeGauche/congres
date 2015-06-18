<?php

namespace AppBundle\Entity\Event;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Booking.
 *
 * @ORM\Table(name="booking")
 * @ORM\Entity(repositoryClass="BookingRepository")
 */
class Booking
{

    const PRICE_1 = 'Moins de 500 euros';
    const PRICE_2 = 'Entre 500 et 1000 euros';
    const PRICE_3 = 'Entre 1000 et 1500 euros';
    const PRICE_4 = 'Entre 1500 et 2000 euros';
    const PRICE_5 = 'Entre 2000 et 2500 euros';
    const PRICE_6 = 'Entre 2500 et 3000 euros';
    const PRICE_7 = 'Plus de 3000 euros';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Adherent
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Adherent")
     * @Assert\NotNull
     */
    private $adherent;

    /**
     * @var datetime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var Bedroom
     *
     * @ORM\ManyToOne(targetEntity="Bedroom")
     */
    private $bedroom;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_payed", type="boolean", nullable=true)
     */
    private $isPayed;

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

    /**
     * @return datetime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
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
    public function setBedroom(Bedroom $bedroom)
    {
        $this->bedroom = $bedroom;
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

    /**
     * @return boolean
     */
    public function isIsPayed()
    {
        return $this->isPayed;
    }

    /**
     * @param boolean $isPayed
     */
    public function setIsPayed($isPayed)
    {
        $this->isPayed = $isPayed;
    }


}