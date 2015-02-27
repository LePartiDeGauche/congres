<?php

namespace AppBundle\Entity\Event;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * EventRole
 *
 * @ORM\Table(name="event_role")
 * @ORM\Entity
 */
class EventRole
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
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="roles")
     * @ORM\JoinColumn(name="event", referencedColumnName="id")
     */
    private $event;

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
     * @var \stdClass
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Instance")
     */
    private $requiredResponsabilities;


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
     * Set event
     *
     * @param Event $event
     * @return EventRole
     */
    public function setEvent(Event $event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return \stdClass 
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return EventRole
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
     * @return EventRole
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
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
     * Set requieredResponsa
     *
     * @param \stdClass $requieredResponsabilities
     * @return EventRole
     */
    public function setRequiredResponsabilities($requieredResponsa)
    {
        $this->requiredResponsabilities = $requieredResponsa;

        return $this;
    }

    /**
     * Get requiredResponsabilities
     *
     * @return \stdClass 
     */
    public function getRequiredResponsabilities()
    {
        return $this->requiredResponsabilities;
    }

    public function __construct()
    {
        $this->requiredResponsabilities = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }
}
