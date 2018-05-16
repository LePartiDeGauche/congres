<?php

namespace AppBundle\Entity\Election;

use AppBundle\Entity\Adherent;
use AppBundle\Entity\Organ\Organ;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\AdherentResponsability;

/**
 * Election.
 *
 * @ORM\Table(name="election")
 * @ORM\Entity(repositoryClass="ElectionRepository")
 * @Vich\Uploadable
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
     * Assert\Expression(
     *     "this.getElected().count() <= this.getNumberOfElected()",
     *     message="Trop d'élus selectionnés",
     *     groups={"report_election"}
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
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @var File
     *
     * @Vich\UploadableField(mapping="minutes_document", fileNameProperty="minutesDocumentFilename")
     */
    private $minutesDocumentFile;

    /**
     * Filename of the minutes document file
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $minutesDocumentFilename;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @var File
     *
     * @Vich\UploadableField(mapping="minutes_document", fileNameProperty="tallySheetFilename")
     */
    private $tallySheetFile;

    /**
     * Filename of the tally sheet file
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tallySheetFilename;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

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
    public function getMaleElectedNames()
    {
        return implode(', ', $this->maleElectionResults->toArray());
    }

    /**
     * @return string
     */
    public function getFemaleElectedNames()
    {
        return implode(', ', $this->femaleElectionResults->toArray());
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

    public function getMaleElectedEmail()
    {
        return implode(', ', $this->maleElectionResults->map(
            function (ElectionResult $electionResult) {
                return $electionResult->getElected()->getEmail();
        })->toArray());
    }

    public function getFemaleElectedEmail()
    {
        return implode(', ', $this->femaleElectionResults->map(
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

    /**
      * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
      * of 'UploadedFile' is injected into this setter to trigger the  update. If this
      * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
      * must be able to accept an instance of 'File' as the bundle will inject one here
      * during Doctrine hydration.
      *
      * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $doc
      *
      * @return Election
      */
     public function setMinutesDocumentFile(File $file = null)
     {
         $this->minutesDocumentFile = $file;

         if ($file) {
             // It is required that at least one field changes if you are using doctrine
             // otherwise the event listeners won't be called and the file is lost
             $this->updatedAt = new \DateTimeImmutable();
         }

         return $this;
     }

     /**
      * @return File|null
      */
     public function getMinutesDocumentFile()
     {
         return $this->minutesDocumentFile;
     }

    /**
     * Set minutesDocumentFilename
     *
     * @param string $minutesDocumentFilename
     *
     * @return Election
     */
    public function setMinutesDocumentFilename($minutesDocumentFilename)
    {
        $this->minutesDocumentFilename = $minutesDocumentFilename;

        return $this;
    }

    /**
     * Get minutesDocumentFilename
     *
     * @return string
     */
    public function getMinutesDocumentFilename()
    {
        return $this->minutesDocumentFilename;
    }

    // public function __set($name, $value)
    // {
    //     if ($name == '$minutesDocumentFilename') {
    //         return $this->setMinutesDocumentFilename($value);
    //     }
    //     if ($name == '$tallySheetFilename') {
    //         return $this->setTallySheetFilename($value);
    //     }
    // }
    //
    // public function __get($name)
    // {
    //     if ($name == '$minutesDocumentFilename') {
    //         return $this->getMinutesDocumentFilename();
    //     }
    //     if ($name == '$tallySheetFilename') {
    //         return $this->getTallySheetFilename();
    //     }
    // }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Election
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }


    /**
     * Set tallySheetFilename
     *
     * @param string $tallySheetFilename
     *
     * @return Election
     */
    public function setTallySheetFilename($tallySheetFilename)
    {
        $this->tallySheetFilename = $tallySheetFilename;

        return $this;
    }

    /**
     * Get tallySheetFilename
     *
     * @return string
     */
    public function getTallySheetFilename()
    {
        return $this->tallySheetFilename;
    }

    /**
    * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
    * of 'UploadedFile' is injected into this setter to trigger the  update. If this
    * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
    * must be able to accept an instance of 'File' as the bundle will inject one here
    * during Doctrine hydration.
    *
    * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $file
    *
    * @return Election
    */
    public function setTallySheetFile(File $file = null)
    {
        $this->tallySheetFile = $file;

        if ($file) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
    * @return File|null
    */
    public function getTallySheetFile()
    {
        return $this->tallySheetFile;
    }
}
