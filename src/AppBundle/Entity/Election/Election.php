<?php

namespace AppBundle\Entity\Election;

use AppBundle\Entity\Adherent;
use AppBundle\Entity\Organ\Organ;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Election.
 *
 * @ORM\Table(name="election")
 * @ORM\Entity(repositoryClass="ElectionRepository")
 */
class Election
{
    const STATUS_OPEN = 'Election Ouverte';
    const STATUS_CLOSED = 'Election Fermée';
    const ISVALID_TRUE = 'Election validée';
    const ISVALID_FALSE = 'Election rejetée';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * The type of the Election.
     *
     * @var \AppBundle\Entity\Election\ElectionGroup
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Election\ElectionGroup")
     * @Assert\NotNull
     */
    private $group;

    /**
     * The localisation of the Election.
     *
     * @var \AppBundle\Entity\Organ\Organ
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Organ\Organ")
     */
    private $organ;

    /**
     * The status of the election, open or closed.
     *
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     * @Assert\NotBlank
     */
    private $status;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint", nullable=true)
     * @Assert\Range(min=1)
     */
    private $numberOfElected;

    /**
     * The responsable of the election.
     *
     * @var \AppBundle\Entity\Adherent
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Adherent")
     */
    private $responsable;

    /**
     * @var Adherent[]
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Adherent")
     * @Assert\Expression(
     *     "this.getElected().count() <= this.getNumberOfElected()",
     *     message="Trop d'élus selectionnés",
     *     groups={"report_election"}
     * )
     */
    private $elected;

    /**
     * Is the election validate by an admin.
     *
     * @var bool
     *
     * @ORM\Column(name="is_valid", type="boolean")
     */
    private $isValid;

    /**
     * Number of voters.
     *
     * @var int
     *
     * @ORM\Column(type="smallint", nullable=true)
     * @Assert\Range(min=1)
     */
    private $numberOfVoters;

    /**
     * Number of valid votes.
     *
     * @var int
     *
     * @ORM\Column(type="smallint", nullable=true)
     * @Assert\Range(min=1)
     */
    private $validVotes;

    /**
     * Number of blank votes.
     *
     * @var int
     *
     * @ORM\Column(type="smallint", nullable=true)
     * @Assert\Range(min=1)
     */
    private $blankVotes;

    /**
     * @return string
     */
    public function __toString()
    {
        return '#'.$this->elected;
    }

    public function __construct()
    {
        $this->elected = new ArrayCollection();
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
     * @return ElectionGroup
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param ElectionGroup $group
     */
    public function setGroup(ElectionGroup $group)
    {
        $this->group = $group;
    }

    /**
     * @return Organ
     */
    public function getOrgan()
    {
        return $this->organ;
    }

    /**
     * @param Organ $organ
     */
    public function setOrgan(Organ $organ)
    {
        $this->organ = $organ;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return Status
     */
    public function setStatus($status)
    {
        if (!in_array($status, array(
            self::STATUS_OPEN,
            self::STATUS_CLOSED,
            self::ISVALID_TRUE,
            self::ISVALID_FALSE,
        ))) {
            throw new \InvalidArgumentException('Invalid status');
        }

        $this->status = $status;

        return $this;
    }

    /**
     * @return Adherent
     */
    public function getResponsable()
    {
        return $this->responsable;
    }

    /**
     * @param Adherent $responsable
     */
    public function setResponsable(Adherent $responsable)
    {
        $this->responsable = $responsable;
    }

    /**
     * @return int
     */
    public function getNumberOfElected()
    {
        return $this->numberOfElected;
    }

    /**
     * @param int $numberOfElected
     *
     * @return Election
     */
    public function setNumberOfElected($numberOfElected)
    {
        $this->numberOfElected = $numberOfElected;

        return $this;
    }

    /**
     * @return Adherent[]
     */
    public function getElected()
    {
        return $this->elected;
    }

    /**
     * @return string
     */
    public function getElectedNames()
    {
        return implode(', ', $this->elected->toArray());
    }

    /**
     * @param Adherent[] $elected
     *
     * @return $this
     */
    public function setElected($elected)
    {
        $this->elected = $elected;

        return $this;
    }

    /**
     * Returns true if election has been checked wether it has been validated
     * or rejected.
     *
     * @return bool
     */
    public function hasBeenChecked()
    {
        return ($this->getStatus() == self::ISVALID_TRUE
             || $this->getStatus() == self::ISVALID_FALSE);
    }

    /**
     * @return bool
     */
    public function isIsValid()
    {
        return $this->isValid;
    }

    /**
     * @param bool $isValid
     */
    public function setIsValid($isValid)
    {
        $this->isValid = $isValid;
    }

    public function getElectedEmail()
    {
        return implode(', ', $this->elected->map(function (Adherent $elected) {
            return $elected->getEmail();
        })->toArray());
    }

    /**
     * @return int
     */
    public function getNumberOfVoters()
    {
        return $this->numberOfVoters;
    }

    /**
     * @param int $numberOfVoters
     */
    public function setNumberOfVoters($numberOfVoters)
    {
        $this->numberOfVoters = $numberOfVoters;
    }

    /**
     * @return int
     */
    public function getValidVotes()
    {
        return $this->validVotes;
    }

    /**
     * @param int $validVotes
     */
    public function setValidVotes($validVotes)
    {
        $this->validVotes = $validVotes;
    }

    /**
     * @return int
     */
    public function getBlankVotes()
    {
        return $this->blankVotes;
    }

    /**
     * @param int $blankVotes
     */
    public function setBlankVotes($blankVotes)
    {
        $this->blankVotes = $blankVotes;
    }
}
