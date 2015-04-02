<?php

namespace AppBundle\Entity\Event;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * EventAdherentRegistration
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Event\EventAdherentRegistrationRepository")
 */
class EventAdherentRegistration
{

    const PAYMENT_MODE_ONLINE = 'online';
    const PAYMENT_MODE_ONSITE = 'onsite';

    const ATTENDANCE_PRESENT ='present';
    const ATTENDANCE_ABSENT ='absent';
    const ATTENDANCE_NOT_REGISTRED = 'not registred';

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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Adherent")
     * @ORM\JoinColumn(nullable=false)
     *
     * Person making the registration
     *
     */
    private $author;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Adherent", inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     *
     *  Adherent who participate
     *
     */
    private $adherent;

    /**
     * @var \stdClass
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Payment\EventPayment", mappedBy="attachedRegistration",cascade={"persist"})
     */
    private $payments;

    /**
     * @var \stdClass
     * 
     * @ORM\ManyToOne(targetEntity="EventRole", inversedBy="participants")
     * @ORM\JoinColumn(nullable=false)
     * 
     */
    private $role;

    /**
     * @var \stdClass
     * 
     * @ORM\ManyToOne(targetEntity="EventCost")
     * @ORM\JoinColumn(nullable=false)
     * 
     */
    private $cost;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="participants")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $event;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToMany(targetEntity="EventMeal", inversedBy="participants")
     *
     */
    private $meals;

    /**
     * @var boolean
     *
     @ORM\Column(name="need_hosting", type="boolean")
     */
    private $needHosting;

    /**
     * @var string
     *
     * @ORM\Column(name="paymentMode", type="string", length=255, nullable=false)
     * Online (CB) or At registration desk
     */
    private $paymentMode;

    /**
     * @var boolean
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
     * @var boolean
     *
     @ORM\Column(name="vote_status", type="boolean")
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set adherent
     *
     * @param \stdClass $adherent
     * @return EventAdherentRegistration
     */
    public function setAdherent($adherent)
    {
        $this->adherent = $adherent;

        return $this;
    }

    /**
     * Get adherent
     *
     * @return \stdClass 
     */
    public function getAdherent()
    {
        return $this->adherent;
    }

    /**
     * Set role
     *
     * @param \stdClass $role
     * @return EventAdherentRegistration
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return \stdClass 
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set event
     *
     * @param \stdClass $event
     * @return EventAdherentRegistration
     */
    public function setEvent($event)
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
     * Set needHosting
     *
     * @param boolean $needHosting
     * @return EventAdherentRegistration
     */
    public function setNeedHosting($needHosting)
    {
        $this->needHosting = $needHosting;

        return $this;
    }

    /**
     * Get needHosting
     *
     * @return boolean 
     */
    public function getNeedHosting()
    {
        return $this->needHosting;
    }

    /**
     * Set paymentMode
     *
     * @param string $paymentMode
     * @return EventAdherentRegistration
     */
    public function setPaymentMode($paymentMode)
    {
        if (!in_array($paymentMode, array(
            self::PAYMENT_MODE_ONLINE,
            self::PAYMENT_MODE_ONSITE)))
        {
            throw new \InvalidArgumentException('Invalid payment mode');
        }
        $this->paymentMode = $paymentMode;

        return $this;
    }

    /**
     * Get paymentMode
     *
     * @return string 
     */
    public function getPaymentMode()
    {
        return $this->paymentMode;
    }

    /**
     * Set registrationDate
     *
     * @param \DateTime $registrationDate
     * @return EventAdherentRegistration
     */
    public function setRegistrationDate($registrationDate)
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    /**
     * Get registrationDate
     *
     * @return \DateTime 
     */
    public function getRegistrationDate()
    {
        return $this->registrationDate;
    }

    /**
     * Set author
     *
     * @param \AppBundle\Entity\Adherent $author
     * @return EventAdherentRegistration
     */
    public function setAuthor(\AppBundle\Entity\Adherent $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \AppBundle\Entity\Adherent 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Add meals
     *
     * @param \AppBundle\Entity\Event\EventMeal $meals
     * @return EventAdherentRegistration
     */
    public function addMeal(\AppBundle\Entity\Event\EventMeal $meals)
    {
        $this->meals[] = $meals;

        return $this;
    }

    /**
     * Remove meals
     *
     * @param \AppBundle\Entity\Event\EventMeal $meals
     */
    public function removeMeal(\AppBundle\Entity\Event\EventMeal $meals)
    {
        $this->meals->removeElement($meals);
    }

    /**
     * Get meals
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMeals()
    {
        return $this->meals;
    }

    /**
     * Set cost
     *
     * @param \AppBundle\Entity\Event\EventCost $cost
     * @return EventAdherentRegistration
     */
    public function setCost(\AppBundle\Entity\Event\EventCost $cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost
     *
     * @return \AppBundle\Entity\Event\EventCost 
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Add payments
     *
     * @param \AppBundle\Entity\Payment\EventPayment $payments
     * @return EventAdherentRegistration
     */
    public function addPayment(\AppBundle\Entity\Payment\EventPayment $payments)
    {
        $this->payments[] = $payments;

        return $this;
    }

    /**
     * Remove payments
     *
     * @param \AppBundle\Entity\Payment\EventPayment $payments
     */
    public function removePayment(\AppBundle\Entity\Payment\EventPayment $payments)
    {
        $this->payments->removeElement($payments);
    }

    /**
     * Get payments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPayments()
    {
        return $this->payments;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return EventAdherentRegistration
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set voteStatus
     *
     * @param boolean $voteStatus
     * @return EventAdherentRegistration
     */
    public function setVoteStatus($voteStatus)
    {
        $this->voteStatus = $voteStatus;

        return $this;
    }

    /**
     * Get voteStatus
     *
     * @return boolean 
     */
    public function getVoteStatus()
    {
        return $this->voteStatus;
    }

    /**
     * Set attendance
     *
     * @param string $attendance
     * @return EventAdherentRegistration
     */
    public function setAttendance($attendance)
    {
        if (!in_array($attendance, array(
            self::ATTENDANCE_PRESENT,
            self::ATTENDANCE_ABSENT,
            self::ATTENDANCE_NOT_REGISTRED)))
        {
            throw new \InvalidArgumentException('Invalid attendance status');
        }
        $this->attendance = $attendance;

        return $this;
    }

    /**
     * Get attendance
     *
     * @return string 
     */
    public function getAttendance()
    {
        return $this->attendance;
    }
}
