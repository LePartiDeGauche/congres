<?php

namespace AppBundle\Entity\Event;

use Doctrine\ORM\Mapping as ORM;

/**
 * EventAdherentRegistration
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class EventAdherentRegistration
{

    const PAYMENT_MODE_ONLINE = 'online';
    const PAYMENT_MODE_ONSITE = 'onsite';
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
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Payment\EventPayment", inversedBy="attachedRegistration")
     */
    private $payment;

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
     * @ORM\Column(name="need_hosting", type="boolean")
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




    public function __construct(\AppBundle\Entity\Adherent $author = null)
    {
        $registrationDate = new \DateTime('now');
        $paymentMode = self::PAYMENT_MODE_ONLINE;
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
     * Set payment
     *
     * @param \stdClass $payment
     * @return EventAdherentRegistration
     */
    public function setPayment($payment)
    {
        if (!in_array($status, array(
            self::PAYMENT_MODE_ONLINE,
            self::PAYMENT_MODE_ONSITE)))
        {
            throw new \InvalidArgumentException('Invalid payment mode');
        }
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
}
