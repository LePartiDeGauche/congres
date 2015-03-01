<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Adherent
 *
 * @ORM\Table(name="adherents")
 * @ORM\Entity
 */
class Adherent
{
    const STATUS_OK = 'À jour de cotisation.';
    const STATUS_ATTENTE_RENOUVELLEMENT = 'En attente de renouvellement.';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string 
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthdate", type="date")
     */
    private $birthdate;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\OneToMany(targetEntity="AdherentResponsability", mappedBy="adherent")
     *
     */
    private $responsabilities;

    /**
     * The user associated to this adherent profile.
     * @var User
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User", mappedBy="profile", orphanRemoval=true)
     */
    private $user;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Initialize collection
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
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set id
     *
     * @return integer
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set lastname
     *
     * @param  string   $lastname
     * @return Adherent
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set firstname
     *
     * @param  string   $firstname
     * @return Adherent
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set birthdate
     *
     * @param  \DateTime $birthdate
     * @return Adherent
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set email
     *
     * @param  string   $email
     * @return Adherent
     */
    public function setEmail($email)
    {
        $this->email = $email;

        if ($this->user && $this->user->GetEmail() !== $email) {
            $this->user->setEmail();
        }

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set status
     *
     * @param  string   $status
     * @return Adherent
     */
    public function setStatus($status)
    {
        if (!in_array($status, array(
            self::STATUS_OK,
            self::STATUS_ATTENTE_RENOUVELLEMENT,
        ))) {
            throw new \InvalidArgumentException('Invalid status');
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

}
