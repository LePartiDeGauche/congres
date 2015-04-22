<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Adherent
 *
 * @ORM\Table(name="adherents")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\AdherentRepository")
 */
class Adherent
{
    const STATUS_NEW = 'Nouveau';
    const STATUS_OK = 'À jour de cotisation.';
    const STATUS_ATTENTE_RENOUVELLEMENT = 'En attente de renouvellement.';
    const STATUS_OLD = 'Ancien adhérent';
    const STATUS_EXCLUDED = 'Exclusion';

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
     * @var int$
     *
     * @ORM\Column(name="departement", type="integer")
     */
    // FIXME : Remove this field when organs will be imported
    private $departement;
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AdherentResponsability", mappedBy="adherent", orphanRemoval=true, cascade={"persist"})
     *
     */
    private $responsabilities;

    /**
     * @var string
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Event\EventAdherentRegistration", mappedBy="adherent")
     *
     */
    private $events;

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
        $this->responsabilities = new \Doctrine\Common\Collections\ArrayCollection();
        $this->status = self::STATUS_NEW;
        $this->departement = 0;
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
        if ($status === null)
        {
            $status = self::STATUS_NEW;
        }
        if (!in_array($status, array(
            self::STATUS_NEW,
            self::STATUS_OK,
            self::STATUS_ATTENTE_RENOUVELLEMENT,
            self::STATUS_OLD,
            self::STATUS_EXCLUDED
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

    /**
     * Get responsabilities
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getResponsabilities()
    {
        return $this->responsabilities;
    }

    public function __toString()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    /**
     * Add responsabilities
     *
     * @param \AppBundle\Entity\AdherentResponsability $responsabilities
     * @return Adherent
     */
    public function addResponsability(\AppBundle\Entity\AdherentResponsability $responsability)
    {
        if($responsability->getAdherent() === null)
        {
            $responsability->setAdherent($this); 
        }
        $this->responsabilities[] = $responsability;

        return $this;
    }

    /**
     * Remove responsabilities
     *
     * @param \AppBundle\Entity\AdherentResponsability $responsabilities
     */
    public function removeResponsability(\AppBundle\Entity\AdherentResponsability $responsabilities)
    {
        $this->responsabilities->removeElement($responsabilities);
    }

    /**
     * Add events
     *
     * @param \AppBundle\Entity\Event\EventAdherentRegistration $events
     * @return Adherent
     */
    public function addEvent(\AppBundle\Entity\Event\EventAdherentRegistration $events)
    {
        $this->events[] = $events;

        return $this;
    }

    /**
     * Remove events
     *
     * @param \AppBundle\Entity\Event\EventAdherentRegistration $events
     */
    public function removeEvent(\AppBundle\Entity\Event\EventAdherentRegistration $events)
    {
        $this->events->removeElement($events);
    }

    /**
     * Get events
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     * @return Adherent
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Set departement
     *
     * @param integer $departement
     * @return Adherent
     */
    public function setDepartement($departement)
    {
        $this->departement = $departement;

        return $this;
    }

    /**
     * Get departement
     *
     * @return integer 
     */
    public function getDepartement()
    {
        return $this->departement;
    }
}
