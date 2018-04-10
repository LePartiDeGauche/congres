<?php

namespace AppBundle\Entity\Text;

use AppBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * And amendment deposit that contains many amendment item
 *
 * @ORM\Table(name="amendment_deposits")
 * @ORM\Entity
 * @Vich\Uploadable
 */
class AmendmentDeposit
{
    private static $origins = array(
        'D' => 'Département',
        'SN'         => 'SEN',
        'C'  => 'Commission',
        '6'          => '6 membres du CN',
        '50'   => '50 adhérent.e.s'
    );

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * The mandatary of the contribution.
     *
     * @var \AppBundle\Entity\Adherent
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Adherent")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     */
    private $mandatary;

    /**
     * @var string
     *
     * @ORM\Column(name="mandatary_info", type="string", length=255)
     */
    private $mandataryInfo;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Adherent")
     * @ORM\JoinColumn(nullable=false)
     */
    private $depositor;

    /**
     * @var string
     *
     * @ORM\Column(name="origin", type="string", length=255)
     * @Assert\Choice(callback = "getOriginValues")
     */
    private $origin;

    /**
     * @var string
     *
     * @ORM\Column(name="origin_info", type="string", length=255, nullable=true)
     */
    private $originInfo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="meetingDate", type="date")
     * @Assert\Date
     */
    private $meetingDate;

    /**
     * @var string
     *
     * @ORM\Column(name="meeting_place", type="string", length=255)
     */
    private $meetingPlace;

    /**
     * The number of present.
     *
     * @var int
     *
     * @ORM\Column(name="number_present", type="integer")
     * @Assert\Type(type="integer")
     */
    private $numberOfPresent = 0;

    /**
     * The amendment process of the contribution.
     *
     * @var \AppBundle\Entity\Process\AmendmentProcess
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Process\AmendmentProcess",
     *                inversedBy="amendments")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     */
    private $amendmentProcess;

    /**
     * The amendment items of this global amendment deposit
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Text\AmendmentItem", mappedBy="amendmentDeposit")
     */
    private $items;


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
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * Is validated
     *
     * @var bool
     *
     * @ORM\Column(name="is_validated", type="boolean", nullable=true)
     */
    private $isValidated = false;

    public function __construct()
    {
        $this->meetingDate = new \DateTime();
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return '#'.$this->id ?: '';
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Adherent
     */
    public function getMandatary()
    {
        return $this->mandatary;
    }

    /**
     * @param Adherent $mandatary
     */
    public function setMandatary($mandatary)
    {
        $this->mandatary = $mandatary;
    }

    /**
     * @return \DateTime
     */
    public function getMeetingDate()
    {
        return $this->meetingDate;
    }

    /**
     * @param \DateTime $meetingDate
     */
    public function setMeetingDate(\DateTime $meetingDate = null)
    {
        $this->meetingDate = $meetingDate;
    }

    /**
     * @return int
     */
    public function getNumberOfPresent()
    {
        return $this->numberOfPresent;
    }

    /**
     * @param int $numberOfPresent
     */
    public function setNumberOfPresent($numberOfPresent)
    {
        $this->numberOfPresent = $numberOfPresent;
    }

    /**
     * Set amendmentProcess
     *
     * @param \AppBundle\Entity\Process\AmendmentProcess $amendmentProcess
     *
     * @return Amendment
     */
    public function setAmendmentProcess(\AppBundle\Entity\Process\AmendmentProcess $amendmentProcess)
    {
        $this->amendmentProcess = $amendmentProcess;

        return $this;
    }

    /**
     * Get amendmentProcess
     *
     * @return \AppBundle\Entity\Process\AmendmentProcess
     */
    public function getAmendmentProcess()
    {
        return $this->amendmentProcess;
    }

    /**
     * Set mandataryInfo
     *
     * @param string $mandataryInfo
     *
     * @return Amendment
     */
    public function setMandataryInfo($mandataryInfo)
    {
        $this->mandataryInfo = $mandataryInfo;

        return $this;
    }

    /**
     * Get mandataryInfo
     *
     * @return string
     */
    public function getMandataryInfo()
    {
        return $this->mandataryInfo;
    }

    /**
     * Set meetingPlace
     *
     * @param string $meetingPlace
     *
     * @return Amendment
     */
    public function setMeetingPlace($meetingPlace)
    {
        $this->meetingPlace = $meetingPlace;

        return $this;
    }

    /**
     * Get meetingPlace
     *
     * @return string
     */
    public function getMeetingPlace()
    {
        return $this->meetingPlace;
    }

    /**
     * Set depositor
     *
     * @param \AppBundle\Entity\Adherent $depositor
     *
     * @return Amendment
     */
    public function setDepositor(\AppBundle\Entity\Adherent $depositor)
    {
        $this->depositor = $depositor;

        return $this;
    }

    /**
     * Get depositor
     *
     * @return \AppBundle\Entity\Adherent
     */
    public function getDepositor()
    {
        return $this->depositor;
    }

    /**
     * Set origin
     *
     * @param string $origin
     *
     * @return Amendment
     */
    public function setOrigin($origin)
    {
        $this->origin = $origin;

        return $this;
    }

    /**
     * Get origin
     *
     * @return string
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * Available types.
     *
     * @return array
     */
    public static function getOrigins()
    {
        return self::$origins;
    }

    /**
     * Available values for types.
     *
     * @return array
     */
    public static function getOriginValues()
    {
        return array_keys(self::$origins);
    }

    /**
     * @return string
     */
    public function getHumanReadableOrigin()
    {
        return self::$origins[$this->origin];
    }

    /**
     * Set originInfo
     *
     * @param string $originInfo
     *
     * @return Amendment
     */
    public function setOriginInfo($originInfo)
    {
        $this->originInfo = $originInfo;

        return $this;
    }

    /**
     * Get originInfo
     *
     * @return string
     */
    public function getOriginInfo()
    {
        return $this->originInfo;
    }

    /**
     * Add item
     *
     * @param \AppBundle\Entity\Text\AmendmentItem $item
     *
     * @return AmendmentDeposit
     */
    public function addItem(\AppBundle\Entity\Text\AmendmentItem $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * Remove item
     *
     * @param \AppBundle\Entity\Text\AmendmentItem $item
     */
    public function removeItem(\AppBundle\Entity\Text\AmendmentItem $item)
    {
        $this->items->removeElement($item);
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItems()
    {
        return $this->items;
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
      * @return AmendmentDeposit
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
     * @return AmendmentDeposit
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

    public function __set($name, $value)
    {
        if ($name == '$minutesDocumentFilename') {
            return $this->setMinutesDocumentFilename($value);
        }
        return parent::__set($name, $value);
    }

    public function __get($name)
    {
        if ($name == '$minutesDocumentFilename') {
            return $this->getMinutesDocumentFilename();
        }
        return parent::__get($name);
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return AmendmentDeposit
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
     * Set isValidated
     *
     * @param boolean $isValidated
     *
     * @return AmendmentDeposit
     */
    public function setIsValidated($isValidated)
    {
        $this->isValidated = $isValidated;

        return $this;
    }

    /**
     * Get isValidated
     *
     * @return boolean
     */
    public function getIsValidated()
    {
        return $this->isValidated;
    }
}
