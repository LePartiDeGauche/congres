<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Organ\OrganParticipation;

/**
 * Adherent.
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

    const GENDER_MALE = 'M';
    const GENDER_FEMALE = 'F';
    const GENDER_UNKNOWN = '?';

    /**
     * @var int
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
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=1)
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="mobilephone", type="string", length=100, nullable=true)
     */
    private $mobilephone;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Organ\OrganParticipation",
     *                mappedBy="adherent",
     *                cascade={"persist", "remove"})
     */
    private $organParticipations;

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
    // FIXME : Remove this field when organs will be imported
    private $departement;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AdherentResponsability", mappedBy="adherent", orphanRemoval=true, cascade={"persist"})
     */
    private $responsabilities;

    /**
     * @var string
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Event\EventAdherentRegistration", mappedBy="adherent")
     */
    private $events;

    /**
     * The user associated to this adherent profile.
     *
     * @var User
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User", mappedBy="profile", cascade={"persist", "remove", "refresh"}, orphanRemoval=true)
     */
    private $user;

    /**
     * Constructor.
     */
    public function __construct()
    {
        // Initialize collection
        $this->responsabilities = new \Doctrine\Common\Collections\ArrayCollection();
        $this->organParticipations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->status = self::STATUS_NEW;
        $this->departement = 0;
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
     * Get user.
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set id.
     *
     * @return int
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set lastname.
     *
     * @param string $lastname
     *
     * @return Adherent
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname.
     *
     * @return string
     */
    public function getLastname()
    {
        return ucwords($this->lastname);
    }

    /**
     * Set firstname.
     *
     * @param string $firstname
     *
     * @return Adherent
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname.
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set birthdate.
     *
     * @param \DateTime $birthdate
     *
     * @return Adherent
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate.
     *
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return Adherent
     */
    public function setEmail($email)
    {
        $this->email = $email;

        if ($this->user && $this->user->getEmail() !== $email) {
            // FIXME: $this->user->setEmail($email);
        }

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set status.
     *
     * @param string $status
     *
     * @return Adherent
     */
    public function setStatus($status)
    {
        if ($status === null) {
            $status = self::STATUS_NEW;
        }
        if (!in_array($status, self::getStatusValues())) {
            throw new \InvalidArgumentException('Invalid status');
        }

        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    public static function getStatusValues()
    {
        return array(
            self::STATUS_NEW,
            self::STATUS_OK,
            self::STATUS_ATTENTE_RENOUVELLEMENT,
            self::STATUS_OLD,
            self::STATUS_EXCLUDED,
        );
    }

    /**
     * Get responsabilities.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getResponsabilities()
    {
        return $this->responsabilities;
    }

    /**
     * Get responsabilities as string
     * FIXME used by getExportFields in sonata admin
     *
     * @return string
     */
    public function getResponsabilitiesAsString()
    {
        return join(', ', array_map(
            function (AdherentResponsability $ar){
                return $ar->getResponsability();
            },
            $this->responsabilities->toArray()
        ));
    }

    /**
     * Get organs as string.
     * FIXME used by getExportFields in sonata admin
     *
     * @return string
     */
    public function getOrgansAsString()
    {
        return join(', ', array_map(
            function (OrganParticipation $op){
                return $op->getOrgan();
            },
            $this->organParticipations->toArray()
        ));
    }

    public function __toString()
    {
        return $this->firstname.' '.$this->lastname;
    }

    public function getAdherentWithDepartementAndResponsabilitiesAsString() {
        $str = $this->getFirstname() . ' ' . $this->getLastname() . ' - ' . $this->getDepartementNumber();
        foreach ($this->getResponsabilities() as $adhResponsability) {
            if ($adhResponsability->getResponsability()->getName() == Responsability::INSTANCE_SEN) {
                $str .= ' (SEN)';
            } elseif ($adhResponsability->getResponsability()->getName() == Responsability::INSTANCE_CN) {
                $str .= ' (CN)';
            }
        }
        return $str;
    }

    /**
     * Get names of adherent with uppercased lastname
     * @return string
     */
    public function getUpperNames()
    {
        return strtoupper($this->lastname) . ' ' . $this->firstname;
    }

    /**
     * Add responsabilities.
     *
     * @param \AppBundle\Entity\AdherentResponsability $responsabilities
     *
     * @return Adherent
     */
    public function addResponsability(\AppBundle\Entity\AdherentResponsability $responsability)
    {
        if ($responsability->getAdherent() === null) {
            $responsability->setAdherent($this);
        }
        $this->responsabilities[] = $responsability;

        return $this;
    }

    /**
     * Checks if adherent has provided responsability.
     *
     * @param \AppBundle\Entity\AdherentResponsability $responsabilities
     *
     * @return bool
     */
    public function hasResponsability(\AppBundle\Entity\Responsability $responsability)
    {
        foreach ($this->responsabilities as $adh_responsability) {
            if ($adh_responsability->getResponsability() == $responsability) {
                return true;
            }
        }

        return false;
    }

    /**
     * Remove responsabilities.
     *
     * @param \AppBundle\Entity\AdherentResponsability $responsabilities
     */
    public function removeResponsability(\AppBundle\Entity\AdherentResponsability $responsabilities)
    {
        $this->responsabilities->removeElement($responsabilities);
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrganParticipations()
    {
        return $this->organParticipations;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $organParticipations
     */
    public function setOrganParticipations(\Doctrine\Common\Collections\Collection $organParticipations)
    {
        $this->organParticipations = $organParticipations;
    }

    /**
     * Add organ participation.
     *
     * @param \AppBundle\Entity\OrganParticipation $organParticipation
     *
     * @return Adherent
     */
    public function addOrganParticipation(\AppBundle\Entity\Organ\OrganParticipation $organParticipation)
    {
        if ($organParticipation->getAdherent() === null) {
            $organParticipation->setAdherent($this);
        }
        $this->organParticipations[] = $organParticipation;

        return $this;
    }

    /**
     * Remove organ participation.
     *
     * @param \AppBundle\Entity\OrganParticipation $organParticipation
     */
    public function removeOrganParticipation(\AppBundle\Entity\Organ\OrganParticipation $organParticipation)
    {
        $this->organParticipations->removeElement($organParticipation);

        return $this;
    }

    /**
     * Add events.
     *
     * @param \AppBundle\Entity\Event\EventAdherentRegistration $events
     *
     * @return Adherent
     */
    public function addEvent(\AppBundle\Entity\Event\EventAdherentRegistration $events)
    {
        $this->events[] = $events;

        return $this;
    }

    /**
     * Remove events.
     *
     * @param \AppBundle\Entity\Event\EventAdherentRegistration $events
     */
    public function removeEvent(\AppBundle\Entity\Event\EventAdherentRegistration $events)
    {
        $this->events->removeElement($events);
    }

    /**
     * Get events.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Set user.
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Adherent
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Set departement.
     *
     * @param int $departement
     *
     * @return Adherent
     */
    public function setDepartement($departement)
    {
        $this->departement = $departement;

        return $this;
    }

    /**
     * Get departement.
     *
     * @return string
     */
    public function getDepartement()
    {
        if ($this->departement != 0) {
            return $this->departement;
        } else {
            $participations = $this->getOrganParticipations();
            foreach ($participations as $participation) {
                if ($participation->getOrgan()->getOrganType()->getName() == "Coordination départementale") {
                    return $participation->getOrgan()->getName();
                }
            }
        }
        return $this->departement;
    }

    public function getDepartementNumber()
    {
        if ($this->departement != 0) {
            return $this->departement;
        } else {
            $participations = $this->getOrganParticipations();
            foreach ($participations as $participation) {
                if ($participation->getOrgan()->getOrganType()->getName() == "Coordination départementale") {
                    preg_match('/\d+/', $participation->getOrgan()->getDescription(), $id);
                    return $id[0];
                }
            }
        }
        return $this->departement;
    }

    /**
     * Set gender.
     *
     * @param string $gender
     *
     * @return Adherent
     */
    public function setGender($gender)
    {
        switch ($gender) {
            case 'M':
            case 'H':
            case 'G':
                $gender = self::GENDER_MALE;
                break;
            case 'F':
                $gender = self::GENDER_FEMALE;
                break;
            default:
                $gender = self::GENDER_UNKNOWN;
                break;
        }
        $this->gender = $gender;

        return $this;
    }

    public static function getGenderValues()
    {
        return array(
            self::GENDER_MALE,
            self::GENDER_FEMALE,
            self::GENDER_UNKNOWN
        );
    }

    /**
     * Get gender.
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set mobilephone.
     *
     * @param string $mobilephone
     *
     * @return Adherent
     */
    public function setMobilephone($mobilephone)
    {
        $this->mobilephone = $mobilephone;

        return $this;
    }

    /**
     * Get mobilephone.
     *
     * @return string
     */
    public function getMobilephone()
    {
        return $this->mobilephone;
    }
}
