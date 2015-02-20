<?php

namespace AppBundle\Entity\Event;

use Doctrine\ORM\Mapping as ORM;

/**
 * BedNights
 *
 * @ORM\Table(name="bednights")
 * @ORM\Entity
 */
class BedNights
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="sleepingSpot", type="object")
     */
    //FIXME
    private $sleepingSpot;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="night", type="object")
     */
    //FIXME
    private $night;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="payment", type="object")
     */
    //FIXME
    private $payment;

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text")
     */
    private $notes;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set sleepingSpot
     *
     * @param \stdClass $sleepingSpot
     * @return BedNights
     */
    public function setSleepingSpot($sleepingSpot)
    {
        $this->sleepingSpot = $sleepingSpot;

        return $this;
    }

    /**
     * Get sleepingSpot
     *
     * @return \stdClass 
     */
    public function getSleepingSpot()
    {
        return $this->sleepingSpot;
    }

    /**
     * Set night
     *
     * @param \stdClass $night
     * @return BedNights
     */
    public function setNight($night)
    {
        $this->night = $night;

        return $this;
    }

    /**
     * Get night
     *
     * @return \stdClass 
     */
    public function getNight()
    {
        return $this->night;
    }

    /**
     * Set payment
     *
     * @param \stdClass $payment
     * @return BedNights
     */
    public function setPayment($payment)
    {
        $this->payment = $payment;

        return $this;
    }

    /**
     * Get payment
     *
     * @return \stdClass 
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * Set notes
     *
     * @param string $notes
     * @return BedNights
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string 
     */
    public function getNotes()
    {
        return $this->notes;
    }
}
