<?php

namespace AppBundle\Entity\Payment;

use Doctrine\ORM\Mapping as ORM;

/**
 * EventPayment
 *
 * @ORM\Entity
 */
class EventPayment extends Payment
{

    /**
     * @var \stdClass
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Event\EventAdherentRegistration", mappedBy="payment")
     *
     */
    protected $attachedRegistration;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Event\Event", inversedBy="payments")
     *
     */
    protected $attachedEvent;


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
     * Set attachedRegistration
     *
     * @param \stdClass $attachedRegistration
     * @return EventPayment
     */
    public function setAttachedRegistration($attachedRegistration)
    {
        $this->attachedRegistration = $attachedRegistration;

        return $this;
    }

    /**
     * Get attachedRegistration
     *
     * @return \stdClass 
     */
    public function getAttachedRegistration()
    {
        return $this->attachedRegistration;
    }
}
