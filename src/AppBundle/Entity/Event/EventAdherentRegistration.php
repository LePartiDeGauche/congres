<?php

namespace AppBundle\Entity\Event;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * EventAdherentRegistration.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Event\EventAdherentRegistrationRepository")
 */
class EventAdherentRegistration
{
    const PAYMENT_MODE_ONLINE = 'online';
    const PAYMENT_MODE_ONSITE = 'onsite';

    const ATTENDANCE_PRESENT = 'present';
    const ATTENDANCE_ABSENT = 'absent';
    const ATTENDANCE_NOT_REGISTRED = 'not registred';

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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Adherent")
     * @ORM\JoinColumn(nullable=false)
     *
     * Person making the registration
     */
    private $author;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Adherent", inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     *
     *  Adherent who participate
     */
    private $adherent;

    /**
     * @var \stdClass
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Payment\EventPayment", mappedBy="attachedRegistration",cascade={"persist", "remove"})
     */
    private $payments;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="EventRole", inversedBy="participants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $role;

    /**
     * @var string
     *
     * @ORM\Column(name="role_comment", type="string", length=255, nullable=true)
     */
    private $roleComment;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="EventSleepingType")
     */
    private $sleepingType;

    /**
     * @var string
     *
     * @ORM\Column(name="sleeping_type_comment", type="string", length=255, nullable=true)
     */
    private $sleepingTypeComment;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="EventPriceScale")
     */
    private $priceScale;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="EventCost")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $cost;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="participants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $event;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToMany(targetEntity="EventMeal", inversedBy="participants")
     */
    private $meals;

    /**
     * @var string
     *
     * @ORM\Column(name="paymentMode", type="string", length=255, nullable=true)
     * Online (CB) or At registration desk
     */
    private $paymentMode;

    /**
     * @var bool
     *
     * @ORM\Column(name="registrationDate", type="datetime")
     */
    private $registrationDate;

    /**
     * @var text
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;

    /**
     * @var bool
     * @ORM\Column(name="vote_status", type="boolean")
     */
    private $voteStatus;

    /**
     * @var string
     *
     * @ORM\Column(name="attendance", type="string", length=255, nullable=false)
     * Online (CB) or At registration desk
     */
    private $attendance;

    public function __construct(\AppBundle\Entity\Adherent $author = null, Event $event = null)
    {
        $this->author = $author;
        $this->event = $event;
        $this->registrationDate = new \DateTime('now');
        $this->paymentMode = self::PAYMENT_MODE_ONLINE;
        $this->voteStatus = false;
        $this->attendance = self::ATTENDANCE_NOT_REGISTRED;
        $this->payments = new ArrayCollection();
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
     * Set adherent.
     *
     * @param \stdClass $adherent
     *
     * @return EventAdherentRegistration
     */
    public function setAdherent($adherent)
    {
        $this->adherent = $adherent;

        return $this;
    }

    /**
     * Get adherent.
     *
     * @return \stdClass
     */
    public function getAdherent()
    {
        return $this->adherent;
    }

    /**
     * Set role.
     *
     * @param \stdClass $role
     *
     * @return EventAdherentRegistration
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role.
     *
     * @return \stdClass
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set event.
     *
     * @param \stdClass $event
     *
     * @return EventAdherentRegistration
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

    public function isPaid()
    {
        return (false === is_null($this->getCost()));
    }

    /**
     * Set paymentMode.
     *
     * @param string $paymentMode
     *
     * @return EventAdherentRegistration
     */
    public function setPaymentMode($paymentMode)
    {
        if (!in_array($paymentMode, array(
            self::PAYMENT_MODE_ONLINE,
            self::PAYMENT_MODE_ONSITE, ))) {
            throw new \InvalidArgumentException('Invalid payment mode');
        }
        $this->paymentMode = $paymentMode;

        return $this;
    }

    /**
     * Get paymentMode.
     *
     * @return string
     */
    public function getPaymentMode()
    {
        return $this->paymentMode;
    }

    /**
     * Set registrationDate.
     *
     * @param \DateTime $registrationDate
     *
     * @return EventAdherentRegistration
     */
    public function setRegistrationDate($registrationDate)
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    /**
     * Get registrationDate.
     *
     * @return \DateTime
     */
    public function getRegistrationDate()
    {
        return $this->registrationDate;
    }

    /**
     * Set author.
     *
     * @param \AppBundle\Entity\Adherent $author
     *
     * @return EventAdherentRegistration
     */
    public function setAuthor(\AppBundle\Entity\Adherent $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author.
     *
     * @return \AppBundle\Entity\Adherent
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Add meals.
     *
     * @param \AppBundle\Entity\Event\EventMeal $meals
     *
     * @return EventAdherentRegistration
     */
    public function addMeal(\AppBundle\Entity\Event\EventMeal $meals)
    {
        $this->meals[] = $meals;

        return $this;
    }

    /**
     * Remove meals.
     *
     * @param \AppBundle\Entity\Event\EventMeal $meals
     */
    public function removeMeal(\AppBundle\Entity\Event\EventMeal $meals)
    {
        $this->meals->removeElement($meals);
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
     * Set cost.
     *
     * @param \AppBundle\Entity\Event\EventCost $cost
     *
     * @return EventAdherentRegistration
     */
    public function setCost(\AppBundle\Entity\Event\EventCost $cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost.
     *
     * @return \AppBundle\Entity\Event\EventCost
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Add payments.
     *
     * @param \AppBundle\Entity\Payment\EventPayment $payments
     *
     * @return EventAdherentRegistration
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
     * Get payments.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPayments()
    {
        return $this->payments;
    }

    /**
     * Set comment.
     *
     * @param string $comment
     *
     * @return EventAdherentRegistration
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment.
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set voteStatus.
     *
     * @param bool $voteStatus
     *
     * @return EventAdherentRegistration
     */
    public function setVoteStatus($voteStatus)
    {
        $this->voteStatus = $voteStatus;

        return $this;
    }

    /**
     * Get voteStatus.
     *
     * @return bool
     */
    public function getVoteStatus()
    {
        return $this->voteStatus;
    }

    /**
     * Set attendance.
     *
     * @param string $attendance
     *
     * @return EventAdherentRegistration
     */
    public function setAttendance($attendance)
    {
        if (!in_array($attendance, array(
            self::ATTENDANCE_PRESENT,
            self::ATTENDANCE_ABSENT,
            self::ATTENDANCE_NOT_REGISTRED, ))) {
            throw new \InvalidArgumentException('Invalid attendance status');
        }
        $this->attendance = $attendance;

        return $this;
    }

    /**
     * Get attendance.
     *
     * @return string
     */
    public function getAttendance()
    {
        return $this->attendance;
    }

    /**
     * Set sleepingType
     *
     * @param \AppBundle\Entity\Event\EventSleepingType $sleepingType
     *
     * @return EventAdherentRegistration
     */
    public function setSleepingType(\AppBundle\Entity\Event\EventSleepingType $sleepingType = null)
    {
        $this->sleepingType = $sleepingType;

        return $this;
    }

    /**
     * Get sleepingType
     *
     * @return \AppBundle\Entity\Event\EventSleepingType
     */
    public function getSleepingType()
    {
        return $this->sleepingType;
    }

    /**
     * Set priceScale
     *
     * @param \AppBundle\Entity\Event\EventPriceScale $priceScale
     *
     * @return EventAdherentRegistration
     */
    public function setPriceScale(\AppBundle\Entity\Event\EventPriceScale $priceScale = null)
    {
        $this->priceScale = $priceScale;

        return $this;
    }

    /**
     * Get priceScale
     *
     * @return \AppBundle\Entity\Event\EventPriceScale
     */
    public function getPriceScale()
    {
        return $this->priceScale;
    }

    /**
     * Set roleComment
     *
     * @param string $roleComment
     *
     * @return EventAdherentRegistration
     */
    public function setRoleComment($roleComment)
    {
        $this->roleComment = $roleComment;

        return $this;
    }

    /**
     * Get roleComment
     *
     * @return string
     */
    public function getRoleComment()
    {
        return $this->roleComment;
    }

    /**
     * Set sleepingTypeComment
     *
     * @param string $sleepingTypeComment
     *
     * @return EventAdherentRegistration
     */
    public function setSleepingTypeComment($sleepingTypeComment)
    {
        $this->sleepingTypeComment = $sleepingTypeComment;

        return $this;
    }

    /**
     * Get sleepingTypeComment
     *
     * @return string
     */
    public function getSleepingTypeComment()
    {
        return $this->sleepingTypeComment;
    }
}
