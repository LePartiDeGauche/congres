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
     * @ORM\Column(name="amount", type="integer")
     */
    private $amount;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="method", type="object")
     */
    //FIXME
    private $method;

    /**
     * @var boolean
     *
     * @ORM\Column(name="cashed", type="boolean")
     */
    private $cashed;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="drawer", type="object")
     */
    //FIXME
    private $drawer;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="recipient", type="object")
     */
    //FIXME
    private $recipient;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="author", type="object")
     */
    //FIXME
    private $author;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;


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
}
