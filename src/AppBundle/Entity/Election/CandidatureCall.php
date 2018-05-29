<?php

namespace AppBundle\Entity\Election;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Adherent;

/**
 * CandidatureCall
 *
 * @ORM\Table(name="candidature_call")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Election\CandidatureCallRepository")
 */
class CandidatureCall
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="openingDate", type="datetime")
     */
    private $openingDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="closingDate", type="datetime")
     */
    private $closingDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="vacancyNumber", type="integer")
     */
    private $vacancyNumber;

    /**
     * @var array
     *
     * @ORM\Column(name="gender", type="string", length=1, nullable=true)
     */
    private $gender;

    /**
     * @var AppBundle\Entity\Responsability
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Responsability")
     */
    private $responsability;

    /**
     * @var integer
     *
     * @ORM\Column(name="faithProfessionLength", type="integer")
     */
    private $faithProfessionLength;

    /**
     * @var integer
     *
     * @ORM\Column(name="faithProfessionDescription", type="text")
     */
    private $faithProfessionDescription;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isVisible", type="boolean", options={"default": false}, nullable=true)
     */
    private $isVisible;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_task_enabled", type="boolean", options={"default": false}, nullable=true)
     */
    private $isTaskEnabled;

    /**
     * @var string
     *
     * @ORM\Column(name="task_description", type="string", length=255, nullable=true)
     */
    private $taskDescription;

    /**
     */
    public function __construct()
    {
        $this->responsabilities = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     *
     * @return CandidatureCall
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return CandidatureCall
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set openingDate
     *
     * @param \DateTime $openingDate
     *
     * @return CandidatureCall
     */
    public function setOpeningDate($openingDate)
    {
        $this->openingDate = $openingDate;

        return $this;
    }

    /**
     * Get openingDate
     *
     * @return \DateTime
     */
    public function getOpeningDate()
    {
        return $this->openingDate;
    }

    /**
     * Set closingDate
     *
     * @param \DateTime $closingDate
     *
     * @return CandidatureCall
     */
    public function setClosingDate($closingDate)
    {
        $this->closingDate = $closingDate;

        return $this;
    }

    /**
     * Get closingDate
     *
     * @return \DateTime
     */
    public function getClosingDate()
    {
        return $this->closingDate;
    }

    /**
     * Set vacancyNumber
     *
     * @param integer $vacancyNumber
     *
     * @return CandidatureCall
     */
    public function setVacancyNumber($vacancyNumber)
    {
        $this->vacancyNumber = $vacancyNumber;

        return $this;
    }

    /**
     * Get vacancyNumber
     *
     * @return integer
     */
    public function getVacancyNumber()
    {
        return $this->vacancyNumber;
    }

    /**
     * Set faithProfessionLength
     *
     * @param integer $faithProfessionLength
     *
     * @return CandidatureCall
     */
    public function setFaithProfessionLength($faithProfessionLength)
    {
        $this->faithProfessionLength = $faithProfessionLength;

        return $this;
    }

    /**
     * Get faithProfessionLength
     *
     * @return integer
     */
    public function getFaithProfessionLength()
    {
        return $this->faithProfessionLength;
    }

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return CandidatureCall
     */
    public function setGender($gender)
    {
        if (!is_null($gender)) {
            $gender = strtoupper($gender);
            switch ($gender) {
                case 'M':
                case 'H':
                case 'G':
                    $gender = Adherent::GENDER_MALE;
                    break;
                case 'F':
                    $gender = Adherent::GENDER_FEMALE;
                    break;
                default:
                    $gender = Adherent::GENDER_UNKNOWN;
                    break;
            }
        }
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return array
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set faithProfessionDescription
     *
     * @param string $faithProfessionDescription
     *
     * @return CandidatureCall
     */
    public function setFaithProfessionDescription($faithProfessionDescription)
    {
        $this->faithProfessionDescription = $faithProfessionDescription;

        return $this;
    }

    /**
     * Get faithProfessionDescription
     *
     * @return string
     */
    public function getFaithProfessionDescription()
    {
        return $this->faithProfessionDescription;
    }

    /**
     * Set responsability
     *
     * @param \AppBundle\Entity\Responsability $responsability
     *
     * @return CandidatureCall
     */
    public function setResponsability(\AppBundle\Entity\Responsability $responsability = null)
    {
        $this->responsability = $responsability;

        return $this;
    }

    /**
     * Get responsability
     *
     * @return \AppBundle\Entity\Responsability
     */
    public function getResponsability()
    {
        return $this->responsability;
    }

    /**
     * Set isVisible
     *
     * @param boolean $isVisible
     *
     * @return CandidatureCall
     */
    public function setIsVisible($isVisible)
    {
        $this->isVisible = $isVisible;

        return $this;
    }

    /**
     * Get isVisible
     *
     * @return boolean
     */
    public function getIsVisible()
    {
        return $this->isVisible;
    }

    /**
     * Set isTaskEnabled
     *
     * @param boolean $isTaskEnabled
     *
     * @return CandidatureCall
     */
    public function setIsTaskEnabled($isTaskEnabled)
    {
        $this->isTaskEnabled = $isTaskEnabled;

        return $this;
    }

    /**
     * Get isTaskEnabled
     *
     * @return boolean
     */
    public function getIsTaskEnabled()
    {
        return $this->isTaskEnabled;
    }

    /**
     * Set taskDescription
     *
     * @param string $taskDescription
     *
     * @return CandidatureCall
     */
    public function setTaskDescription($taskDescription)
    {
        $this->taskDescription = $taskDescription;

        return $this;
    }

    /**
     * Get taskDescription
     *
     * @return string
     */
    public function getTaskDescription()
    {
        return $this->taskDescription;
    }
}
