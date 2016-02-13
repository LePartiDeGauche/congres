<?php

namespace AppBundle\Entity\Event;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Event.
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Event\EventRepository")
 */
class Event
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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Event\EventAdherentRegistration",
     * mappedBy="event")
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
     * @ORM\Column(name="normalizedName", type="string", length=100)
     */
    private $normalizedName;

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
     * @var boolean
     *
     * @ORM\Column(name="is_roles_comment_enabled", type="boolean", options={"default": true})
     */
    private $isRolesCommentEnabled;

    /**
     * @var boolean
     *
     * @ORM\Column(name="roles_comment_help_text", type="text", nullable=true)
     */
    private $rolesCommentHelpText;

    /**
     * @var \stdClass
     *
     * @ORM\OneToMany(targetEntity="EventCost", mappedBy="event",
     * cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $costs;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToMany(targetEntity="EventPriceScale", mappedBy="events",
     *                cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $priceScales;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToMany(targetEntity="EventSleepingType", mappedBy="events",
     *                cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $sleepingTypes;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_sleeping_types_comment_enabled", type="boolean", options={"default": true})
     */
    private $isSleepingTypesCommentEnabled;

    /**
     * @var boolean
     *
     * @ORM\Column(name="sleeping_types_comment_help_text", type="text", nullable=true)
     */
    private $sleepingTypesCommentHelpText;

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
     */
    private $payments;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="registration_begin", type="datetime")
     */
    private $registrationBegin;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="registration_end", type="datetime")
     */
    private $registrationEnd;

    /**
     * @var \stdClass
     *
     * @ORM\OneToMany(targetEntity="EventMeal", mappedBy="event",
     * cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $meals;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isVisible", type="boolean", options={"default": false}, nullable=true)
     */
    private $isVisible;

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
     * Set participants.
     *
     * @param \stdClass $participants
     *
     * @return Event
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
     * Get number of participants/registrations.
     *
     * @return int
     */
    public function getNbRegistrations()
    {
        return count($this->participants);
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Event
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
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set roles.
     *
     * @param \stdClass $roles
     *
     * @return Event
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles.
     *
     * @return \stdClass
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set sleepingFacilities.
     *
     * @param \stdClass $sleepingFacilities
     *
     * @return Event
     */
    public function setSleepingFacilities($sleepingFacilities)
    {
        $this->sleepingFacilities = $sleepingFacilities;

        return $this;
    }

    /**
     * Get sleepingFacilities.
     *
     * @return \stdClass
     */
    public function getSleepingFacilities()
    {
        return $this->sleepingFacilities;
    }

    /**
     * Set payments.
     *
     * @param \stdClass $payments
     *
     * @return Event
     */
    public function setPayments($payments)
    {
        $this->payments = $payments;

        return $this;
    }

    /**
     * Get payments.
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
        $this->meals = new ArrayCollection();
        $this->costs = new ArrayCollection();
        $this->sleepingFacilities = new ArrayCollection();
        $this->registrationBegin = new \DateTime('now');
    }

    /**
     * Add participants.
     *
     * @param \AppBundle\Entity\Adherent $participants
     *
     * @return Event
     */
    public function addParticipant(\AppBundle\Entity\Adherent $participants)
    {
        $this->participants[] = $participants;

        return $this;
    }

    /**
     * Remove participants.
     *
     * @param \AppBundle\Entity\Adherent $participants
     */
    public function removeParticipant(\AppBundle\Entity\Adherent $participants)
    {
        $this->participants->removeElement($participants);
    }

    /**
     * Add reservationNights.
     *
     * @param \AppBundle\Entity\Event\ReservationNight $reservationNights
     *
     * @return Event
     */
    public function addReservationNight(\AppBundle\Entity\Event\ReservationNight $reservationNights)
    {
        $this->reservationNights[] = $reservationNights;

        return $this;
    }

    /**
     * Remove reservationNights.
     *
     * @param \AppBundle\Entity\Event\ReservationNight $reservationNights
     */
    public function removeReservationNight(\AppBundle\Entity\Event\ReservationNight $reservationNights)
    {
        $this->reservationNights->removeElement($reservationNights);
    }

    /**
     * Get reservationNights.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReservationNights()
    {
        return $this->reservationNights;
    }

    /**
     * Set registrationBegin.
     *
     * @param \DateTime $registrationBegin
     *
     * @return Event
     */
    public function setRegistrationBegin($registrationBegin)
    {
        $this->registrationBegin = $registrationBegin;

        return $this;
    }

    /**
     * Get registrationBegin.
     *
     * @return \DateTime
     */
    public function getRegistrationBegin()
    {
        return $this->registrationBegin;
    }

    /**
     * Set registrationEnd.
     *
     * @param \DateTime $registrationEnd
     *
     * @return Event
     */
    public function setRegistrationEnd($registrationEnd)
    {
        $this->registrationEnd = $registrationEnd;

        return $this;
    }

    /**
     * Get registrationEnd.
     *
     * @return \DateTime
     */
    public function getRegistrationEnd()
    {
        return $this->registrationEnd;
    }

    /**
     * @return int
     */
    public function getNightsDuration()
    {
        return $this->nightsDuration;
    }

    /**
     * @param int $nightsDuration
     */
    public function setNightsDuration($nightsDuration)
    {
        $this->nightsDuration = $nightsDuration;
    }

    /**
     * Add payments.
     *
     * @param \AppBundle\Entity\Payment\EventPayment $payments
     *
     * @return Event
     */
    public function addPayment(\AppBundle\Entity\Payment\EventPayment $payments)
    {
        $this->payments[] = $payments;

        return $this;
    }

    /**
     * Remove payments.
     *
     * @param \AppBundle\Entity\Payment\EventPayment $payments
     */
    public function removePayment(\AppBundle\Entity\Payment\EventPayment $payments)
    {
        $this->payments->removeElement($payments);
    }

    /**
     * Add meals.
     *
     * @param \AppBundle\Entity\Event\EventMeal $meals
     *
     * @return Event
     */
    public function addMeal(\AppBundle\Entity\Event\EventMeal $meal)
    {
        $this->meals[] = $meal;

        return $this;
    }

    /**
     * Remove meals.
     *
     * @param \AppBundle\Entity\Event\EventMeal $meals
     */
    public function removeMeal(\AppBundle\Entity\Event\EventMeal $meal)
    {
        $this->meals->removeElement($meal);
    }

    /**
     * Get meals.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMeals()
    {
        return $this->meals;
    }

    /**
     * Add costs.
     *
     * @param \AppBundle\Entity\Event\EventCost $costs
     *
     * @return Event
     */
    public function addCost(\AppBundle\Entity\Event\EventCost $costs)
    {
        $this->costs[] = $costs;

        return $this;
    }

    /**
     * Remove costs.
     *
     * @param \AppBundle\Entity\Event\EventCost $costs
     */
    public function removeCost(\AppBundle\Entity\Event\EventCost $costs)
    {
        $this->costs->removeElement($costs);
    }

    /**
     * Get costs.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCosts()
    {
        return $this->costs;
    }

    /**
     * Set normalizedName.
     *
     * @param string $normalizedName
     *
     * @return Event
     */
    public function setNormalizedName($normalizedName)
    {
        $this->normalizedName = $normalizedName;

        return $this;
    }

    /**
     * Get normalizedName.
     *
     * @return string
     */
    public function getNormalizedName()
    {
        return $this->normalizedName;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * Add eventPriceScale
     *
     * @param \AppBundle\Entity\Event\EventPriceScale $priceScale
     *
     * @return Event
     */
    public function addPriceScale(\AppBundle\Entity\Event\EventPriceScale $priceScale)
    {
        $this->priceScales[] = $priceScale;

        return $this;
    }

    /**
     * Remove eventPriceScale
     *
     * @param \AppBundle\Entity\Event\EventPriceScale $priceScale
     */
    public function removePriceScale(\AppBundle\Entity\Event\EventPriceScale $priceScale)
    {
        $this->priceScales->removeElement($priceScale);
    }

    /**
     * Get eventPriceScales
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPriceScales()
    {
        return $this->priceScales;
    }

    /**
     * Add SleepingType
     *
     * @param \AppBundle\Entity\Event\EventSleepingType $sleepingType
     *
     * @return Event
     */
    public function addSleepingType(\AppBundle\Entity\Event\EventSleepingType $sleepingType)
    {
        $this->sleepingTypes[] = $sleepingType;

        return $this;
    }

    /**
     * Remove SleepingType
     *
     * @param \AppBundle\Entity\Event\EventSleepingType $sleepingType
     */
    public function removeSleepingType(\AppBundle\Entity\Event\EventSleepingType $sleepingType)
    {
        $this->sleepingTypes->removeElement($sleepingType);
    }

    /**
     * Get SleepingTypes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSleepingTypes()
    {
        return $this->sleepingTypes;
    }

    /**
     * Set isRolesCommentEnabled
     *
     * @param boolean $isRolesCommentEnabled
     *
     * @return Event
     */
    public function setIsRolesCommentEnabled($isRolesCommentEnabled)
    {
        $this->isRolesCommentEnabled = $isRolesCommentEnabled;

        return $this;
    }

    /**
     * Get isRolesCommentEnabled
     *
     * @return boolean
     */
    public function getIsRolesCommentEnabled()
    {
        return $this->isRolesCommentEnabled;
    }

    /**
     * Set rolesCommentHelpText
     *
     * @param string $rolesCommentHelpText
     *
     * @return Event
     */
    public function setRolesCommentHelpText($rolesCommentHelpText)
    {
        $this->rolesCommentHelpText = $rolesCommentHelpText;

        return $this;
    }

    /**
     * Get rolesCommentHelpText
     *
     * @return string
     */
    public function getRolesCommentHelpText()
    {
        return $this->rolesCommentHelpText;
    }

    /**
     * Set isSleepingTypesCommentEnabled
     *
     * @param boolean $isSleepingTypesCommentEnabled
     *
     * @return Event
     */
    public function setIsSleepingTypesCommentEnabled($isSleepingTypesCommentEnabled)
    {
        $this->isSleepingTypesCommentEnabled = $isSleepingTypesCommentEnabled;

        return $this;
    }

    /**
     * Get isSleepingTypesCommentEnabled
     *
     * @return boolean
     */
    public function getIsSleepingTypesCommentEnabled()
    {
        return $this->isSleepingTypesCommentEnabled;
    }

    /**
     * Set sleepingTypesCommentHelpText
     *
     * @param string $sleepingTypesCommentHelpText
     *
     * @return Event
     */
    public function setSleepingTypesCommentHelpText($sleepingTypesCommentHelpText)
    {
        $this->sleepingTypesCommentHelpText = $sleepingTypesCommentHelpText;

        return $this;
    }

    /**
     * Get sleepingTypesCommentHelpText
     *
     * @return string
     */
    public function getSleepingTypesCommentHelpText()
    {
        return $this->sleepingTypesCommentHelpText;
    }

    /**
     * Set isVisible
     *
     * @param boolean $isVisible
     *
     * @return Event
     */
    public function setIsVisible($isVisible)
    {
        $this->isVisible = $isVisible;

        return $this;
    }

    /**
     * Get isVisible
     *
     * @return boolean
     */
    public function getIsVisible()
    {
        return $this->isVisible;
    }
}
