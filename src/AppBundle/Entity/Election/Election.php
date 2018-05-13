<?php

namespace AppBundle\Entity\Election;

use AppBundle\Entity\Adherent;
use AppBundle\Entity\Organ\Organ;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\AdherentResponsability;

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
     * @var ElectionResult[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Election\MaleElectionResult",
     *                mappedBy="election", cascade={"persist"})
     * //Assert\Expression(
     * //    "this.getElected().count() <= this.getNumberOfElected()",
     * //    message="Trop d'élus selectionnés",
     * //    groups={"report_election"}
     * )
     */
    private $maleElectionResults;

    /**
     * @var ElectionResult[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Election\FemaleElectionResult",
     *                mappedBy="election", cascade={"persist"})
     */
    private $femaleElectionResults;

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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=true)
     */
    private $date;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->group . ' - ' . $this->organ;
    }

    public function __construct()
    {
        $this->maleElectionResults = new ArrayCollection();
        $this->femaleElectionResults = new ArrayCollection();
        $this->setIsValid(false);
        $this->setDate(new \DateTimeImmutable());
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
     * @return ElectionResult[]
     */
    public function getMaleElectionResults()
    {
        return $this->maleElectionResults;
    }

    /**
     * @return string
     */
    public function getElectedNames()
    {
        return implode(', ', $this->maleElectionResults->toArray());
    }

    /**
     * @param ElectionResult[] $maleElectionResults
     *
     * @return $this
     */
    public function setMaleElectionResults($maleElectionResults)
    {
        $this->maleElectionResults = $maleElectionResults;

        return $this;
    }

    /**
     * Add an election result.
     *
     * @param ElectionResult $electionResult
     *
     * @return Adherent
     */
    public function addMaleElectionResult(ElectionResult $electionResult)
    {
        $electionResult->setElection($this);
        $this->maleElectionResults[] = $electionResult;

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
        return implode(', ', $this->maleElectionResults->map(
            function (ElectionResult $electionResult) {
                return $electionResult->getElected()->getEmail();
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

    /**
     * Set date of election.
     *
     * @param \DateTime $date
     *
     * @return Election
     */
    public function setDate($date)
    {
        $this->date = isset($date) ? $date : new DateTime();

        return $this;
    }

    /**
     * Get date of election.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Get isValid
     *
     * @return boolean
     */
    public function getIsValid()
    {
        return $this->isValid;
    }

    /**
     * Remove electionResult
     *
     * @param \AppBundle\Entity\Election\ElectionResult $electionResult
     */
    public function removeMaleElectionResult(ElectionResult $electionResult)
    {
        $this->maleElectionResults->removeElement($electionResult);
    }

    /**
     * Add femaleElectionResult
     *
     * @param \AppBundle\Entity\Election\ElectionResult $femaleElectionResult
     *
     * @return Election
     */
    public function addFemaleElectionResult(ElectionResult $femaleElectionResult)
    {
        $femaleElectionResult->setElection($this);
        $this->femaleElectionResults[] = $femaleElectionResult;

        return $this;
    }

    /**
     * Remove femaleElectionResult
     *
     * @param \AppBundle\Entity\Election\ElectionResult $femaleElectionResult
     */
    public function removeFemaleElectionResult(ElectionResult $femaleElectionResult)
    {
        $this->femaleElectionResults->removeElement($femaleElectionResult);
    }

    /**
     * Get femaleElectionResults
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFemaleElectionResults()
    {
        return $this->femaleElectionResults;
    }
}
