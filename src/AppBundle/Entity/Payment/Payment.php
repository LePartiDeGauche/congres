<?php

namespace AppBundle\Entity\Payment;

use Doctrine\ORM\Mapping as ORM;

/**
 * Payment:Payment
 *
 * @ORM\Entity
 * @ORM\Table(name="payment")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="payment_type", type="string")
 * @ORM\DiscriminatorMap({"event" = "EventPayment", "membership" = "MembershipPayment"})
 *
 */
abstract class Payment
{
    const METHOD_CREDIT_CARD = 'card';
    const METHOD_CHEQUE = 'cheque';
    const METHOD_CASH = 'cash';

    const ACCOUNT_PG = 'pg';
    const ACCOUNT_AFPG = 'afpg';


    const STATUS_NEW = 'new';
    const STATUS_PENDING = 'pending';
    const STATUS_BANKED = 'banked';
    const STATUS_REFUSED = 'refused';
    const STATUS_CANCELED = 'canceled';


    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="amount", type="float")
     */
    protected $amount;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="method", type="string", length=20)
     */
    protected $method;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="string", length=20)
     */
    protected $status;

    /**
     * @var \stdClass
     * People who write the cheque / has his name on the credit card
     *
     * @ORM\Column(name="drawer", type="string", length=255, nullable=true)
     * 
     */
    protected $drawer;

    /**
     * @var \stdClass
     * adherent who benefit from the money
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Adherent")
     *
     */
    protected $recipient;

    /**
     * @var \stdClass
     * intranet author of the payment
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Adherent")
     */
    protected $author;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    protected $date;

    /**
     * @var string 
     * intranet author of the payment
     *
     * @ORM\Column(name="account", type="string", length=20)
     *
     */
    protected $account;

    /**
     * @var string
     *
     * Human readable element to group paybox payment in the web interface
     *
     * @ORM\Column(name="referenceIdentifierPrefix", type="string", length=100)
     *
     *
     */
    protected $referenceIdentifierPrefix;

    /**
     * @var array
     *
     * IPN Array from paybox
     *
     * @ORM\Column(name="paymentIPN", type="array", nullable = true)
     *
     */

    protected $paymentIPN;

    public function __construct()
    {
        $this->date = new \DateTime('now');
        $this->account = self::ACCOUNT_PG;
        $this->paymentIPN = array();
    
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
     * Set amount
     *
     * @param integer $amount
     * @return Payment:Payment
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return integer 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set method
     *
     * @param \stdClass $method
     * @return Payment:Payment
     */
    public function setMethod($method)
    {
        if (!in_array($method, array(
            self::METHOD_CREDIT_CARD,
            self::METHOD_CHEQUE,
            self::METHOD_CASH
        )))
        {
            throw new \InvalidArgumentException('Invalid method');
        }
        $this->method = $method;

        return $this;
    }

    /**
     * Get method
     *
     * @return \stdClass 
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Payment:Payment
     */
    public function setStatus($status)
    {
        if (!in_array($status, array(
            self::STATUS_NEW,
            self::STATUS_PENDING,
            self::STATUS_BANKED,
            self::STATUS_REFUSED,
            self::STATUS_CANCELED
        )))
        {
            throw new \InvalidArgumentException('Invalid Status');
        
        }
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set drawer
     *
     * @param \stdClass $drawer
     * @return Payment:Payment
     */
    public function setDrawer($drawer)
    {
        $this->drawer = $drawer;

        return $this;
    }

    /**
     * Get drawer
     *
     * @return \stdClass 
     */
    public function getDrawer()
    {
        return $this->drawer;
    }

    /**
     * Set recipient
     *
     * @param \stdClass $recipient
     * @return Payment:Payment
     */
    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;

        return $this;
    }

    /**
     * Get recipient
     *
     * @return \stdClass 
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * Set author
     *
     * @param \stdClass $author
     * @return Payment:Payment
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \stdClass 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Payment:Payment
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set account
     *
     * @param string $account
     * @return Payment
     */
    public function setAccount($account)
    {
        if (!in_array($account, array(
            self::ACCOUNT_PG,
            self::ACCOUNT_AFPG
        )))
        {
            throw new \InvalidArgumentException('Invalid account');
        }
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return string 
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set referenceIdentifierPrefix
     *
     * @param string $referenceIdentifierPrefix
     * @return Payment
     */
    public function setReferenceIdentifierPrefix($referenceIdentifierPrefix)
    {
        $this->referenceIdentifierPrefix = $referenceIdentifierPrefix;

        return $this;
    }

    /**
     * Get referenceIdentifierPrefix
     *
     * @return string 
     */
    public function getReferenceIdentifierPrefix()
    {
        return $this->referenceIdentifierPrefix;
    }

    /**
     * Set paymentIPN
     *
     * @param array $paymentIPN
     * @return Payment
     */
    public function setPaymentIPN($paymentIPN)
    {
        $this->paymentIPN = $paymentIPN;

        return $this;
    }

    /**
     * Get paymentIPN
     *
     * @return array 
     */
    public function getPaymentIPN()
    {
        return $this->paymentIPN;
    }

    public function __toString()
    {
        return $this->amount . '€ - ' . $this->status;
    
    }
}
