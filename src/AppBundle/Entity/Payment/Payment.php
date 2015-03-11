<?php

namespace AppBundle\Entity\Payment;

use Doctrine\ORM\Mapping as ORM;

/**
 * Payment:Payment
 *
 * @ORM\Table(name="payment")
 * @ORM\Entity
 */
class Payment
{
    const METHOD_CREDIT_CARD = 'card';
    const METHOD_CHEQUE = 'cheque';
    const METHOD_CASH = 'cash';

    const ACCOUNT_PG = 'pg';
    const ACCOUNT_AFPG = 'afpg';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="amount", type="float")
     */
    private $amount;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="method", type="string", length=20)
     */
    private $method;

    /**
     * @var boolean
     *
     * @ORM\Column(name="cashed", type="boolean")
     */
    private $cashed;

    /**
     * @var \stdClass
     * People who write the cheque / has his name on the credit card
     *
     * @ORM\Column(name="drawer", type="string", length=255)
     * 
     */
    private $drawer;

    /**
     * @var \stdClass
     * adherent who benefit from the money
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Adherent")
     *
     */
    private $recipient;

    /**
     * @var \stdClass
     * intranet author of the payment
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Adherent")
     */
    private $author;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string 
     * intranet author of the payment
     *
     * @ORM\Column(name="account", type="string", length=20)
     *
     */
    private $account;

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
        if (!in_array($status, array(
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
     * Set cashed
     *
     * @param boolean $cashed
     * @return Payment:Payment
     */
    public function setCashed($cashed)
    {
        $this->cashed = $cashed;

        return $this;
    }

    /**
     * Get cashed
     *
     * @return boolean 
     */
    public function getCashed()
    {
        return $this->cashed;
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
        if (!in_array($status, array(
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
}
