<?php

namespace AppBundle\Entity\Payment;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Event\Event;
use AppBundle\Entity\Event\EventAdherentRegistration;
use AppBundle\Entity\Adherent;
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Event\EventAdherentRegistration", inversedBy="payments")
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

    public function __construct(Adherent $author = null, Event $event = null, EventAdherentRegistration $eventRegistration = null)
    {
        parent::__construct();
        $this->author = $author;
        $this->attachedEvent = $event;
        $this->attachedRegistration = $eventRegistration;
    }

    /**
     * Set attachedEvent
     *
     * @param \AppBundle\Entity\Event\Event $attachedEvent
     * @return EventPayment
     */
    public function setAttachedEvent(\AppBundle\Entity\Event\Event $attachedEvent = null)
    {
        $this->attachedEvent = $attachedEvent;

        return $this;
    }

    /**
     * Get attachedEvent
     *
     * @return \AppBundle\Entity\Event\Event 
     */
    public function getAttachedEvent()
    {
        return $this->attachedEvent;
    }
}
