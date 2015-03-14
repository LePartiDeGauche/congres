<?php

namespace AppBundle\Entity\Event;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity
 */
class Event
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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Event\EventAdherentRegistration",
     * mappedBy="event")
     * 
     */
    private $participants;

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
     * @var \stdClass
     *
     * @ORM\OneToMany(targetEntity="EventRole", mappedBy="event",
     * cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $roles;

    /**
     * @var \stdClass
     *
     * @ORM\OneToMany(targetEntity="SleepingFacility", mappedBy="event",
     * cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $sleepingFacilities;

    /**
     * @var \stdClass
     *
     * @ORM\OneToMany(targetEntity="ReservationNight", mappedBy="event",
     * cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $reservationNights;


    /**
     * @var \stdClass
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Payment\EventPayment", mappedBy="attachedEvent")
     *
     */
    private $payments;


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
     * Set participants
     *
     * @param \stdClass $participants
     * @return Event
     */
    public function setParticipants($participants)
    {
        $this->participants = $participants;

        return $this;
    }

    /**
     * Get participants
     *
     * @return \stdClass 
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Event
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Event
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function addRole(EventRole $role)
    {
        $role->setEvent($this);

        $this->roles->add($role);
    }

    public function removeRole(EventRole $role)
    {
        $this->roles->remove($role);
    }
    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set roles
     *
     * @param \stdClass $roles
     * @return Event
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return \stdClass 
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set sleepingFacilities
     *
     * @param \stdClass $sleepingFacilities
     * @return Event
     */
    public function setSleepingFacilities($sleepingFacilities)
    {
        $this->sleepingFacilities = $sleepingFacilities;

        return $this;
    }

    /**
     * Get sleepingFacilities
     *
     * @return \stdClass 
     */
    public function getSleepingFacilities()
    {
        return $this->sleepingFacilities;
    }

    /**
     * Set payments
     *
     * @param \stdClass $payments
     * @return Event
     */
    public function setPayments($payments)
    {
        $this->payments = $payments;

        return $this;
    }

    /**
     * Get payments
     *
     * @return \stdClass 
     */
    public function getPayments()
    {
        return $this->payments;
    }

    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->sleepingFacilities = new ArrayCollection();
    }


    /**
     * Add participants
     *
     * @param \AppBundle\Entity\Adherent $participants
     * @return Event
     */
    public function addParticipant(\AppBundle\Entity\Adherent $participants)
    {
        $this->participants[] = $participants;

        return $this;
    }

    /**
     * Remove participants
     *
     * @param \AppBundle\Entity\Adherent $participants
     */
    public function removeParticipant(\AppBundle\Entity\Adherent $participants)
    {
        $this->participants->removeElement($participants);
    }

    /**
     * Add sleepingFacilities
     *
     * @param \AppBundle\Entity\Event\SleepingFacility $sleepingFacilities
     * @return Event
     */
    public function addSleepingFacility(\AppBundle\Entity\Event\SleepingFacility $sleepingFacilities)
    {
        $this->sleepingFacilities[] = $sleepingFacilities;

        return $this;
    }

    /**
     * Remove sleepingFacilities
     *
     * @param \AppBundle\Entity\Event\SleepingFacility $sleepingFacilities
     */
    public function removeSleepingFacility(\AppBundle\Entity\Event\SleepingFacility $sleepingFacilities)
    {
        $this->sleepingFacilities->removeElement($sleepingFacilities);
    }

    /**
     * Add reservationNights
     *
     * @param \AppBundle\Entity\Event\ReservationNight $reservationNights
     * @return Event
     */
    public function addReservationNight(\AppBundle\Entity\Event\ReservationNight $reservationNights)
    {
        $this->reservationNights[] = $reservationNights;

        return $this;
    }

    /**
     * Remove reservationNights
     *
     * @param \AppBundle\Entity\Event\ReservationNight $reservationNights
     */
    public function removeReservationNight(\AppBundle\Entity\Event\ReservationNight $reservationNights)
    {
        $this->reservationNights->removeElement($reservationNights);
    }

    /**
     * Get reservationNights
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReservationNights()
    {
        return $this->reservationNights;
    }
}
