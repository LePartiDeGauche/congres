<?php

namespace AppBundle\Entity\Event;

use Doctrine\ORM\Mapping as ORM;

/**
 * EventMeal.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Event\EventMealRepository")
 */
class EventMeal
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
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="meals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $event;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToMany(targetEntity="EventAdherentRegistration", mappedBy="meals")
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
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="mealTime", type="datetime")
     */
    private $mealTime;

    public function __clone()
    {
        foreach ($this->getParticipants() as $participant) {
            $this->removeParticipant($participant);
        }
    }

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
     * Set event.
     *
     * @param \stdClass $event
     *
     * @return EventMeal
     */
    public function setEvent($event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event.
     *
     * @return \stdClass
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set participants.
     *
     * @param \stdClass $participants
     *
     * @return EventMeal
     */
    public function setParticipants($participants)
    {
        $this->participants = $participants;

        return $this;
    }

    /**
     * Get participants.
     *
     * @return \stdClass
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return EventMeal
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
     * Set description.
     *
     * @param string $description
     *
     * @return EventMeal
     */
    public function setDescription($description)
    {
        $this->description = $description;

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
     * Set time.
     *
     * @param \DateTime $time
     *
     * @return EventMeal
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time.
     *
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->participants = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set mealTime.
     *
     * @param \DateTime $mealTime
     *
     * @return EventMeal
     */
    public function setMealTime($mealTime)
    {
        $this->mealTime = $mealTime;

        return $this;
    }

    /**
     * Get mealTime.
     *
     * @return \DateTime
     */
    public function getMealTime()
    {
        return $this->mealTime;
    }

    public function __toString()
    {
        if (isset($this->description)) {
            return $this->name . ' (' . $this->getDescription() . ')';
        }
        return $this->name;
    }

    /**
     * Add participants.
     *
     * @param \AppBundle\Entity\Event\EventAdherentRegistration $participants
     *
     * @return EventMeal
     */
    public function addParticipant(\AppBundle\Entity\Event\EventAdherentRegistration $participants)
    {
        $this->participants[] = $participants;

        return $this;
    }

    /**
     * Remove participants.
     *
     * @param \AppBundle\Entity\Event\EventAdherentRegistration $participants
     */
    public function removeParticipant(\AppBundle\Entity\Event\EventAdherentRegistration $participants)
    {
        $this->participants->removeElement($participants);
    }
}
