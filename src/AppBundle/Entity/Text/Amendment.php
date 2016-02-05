<?php

namespace AppBundle\Entity\Text;

use AppBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * The amendment proposed to the congress.
 *
 * @ORM\Table(name="amendments")
 * @ORM\Entity
 */
class Amendment
{
    private static $types = array(
        'a' => 'Ajout',
        'd' => 'Suppression',
        'm' => 'Modification',
    );

    private static $natures = array(
        'o' => 'Fond',
        'r' => 'Forme',
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
     * The author of the contribution.
     *
     * @var \AppBundle\Entity\Adherent
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Adherent")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     */
    private $author;

    /**
     * The organ of the contribution.
     *
     * @var \AppBundle\Entity\Organ
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Organ\Organ")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     */
    private $organ;

    /**
     * The text concerned by the amendments.
     *
     * @var \AppBundle\Entity\Text\Text
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Text\Text")
     * @Assert\NotNull
     */
    private $text;

    /**
     * The line concerned by the amendment.
     *
     * @var int
     *
     * @ORM\Column(name="start_line", type="integer")
     * @Assert\NotBlank
     * @Assert\Type(type="integer")
     */
    private $startLine;

    /**
     * The end of line concerned by the amendment.
     *
     * @var int
     *
     * @ORM\Column(name="end_line", type="integer")
     * @Assert\NotBlank
     * @Assert\Type(type="integer")
     */
    private $endLine;

    /**
     * The nature of the amendment : form/fond
     *
     * @var string
     *
     * @ORM\Column(name="nature")
     * @Assert\NotBlank
     * @Assert\Choice(callback = "getNaturesValues")
     */
    private $nature;

    /**
     * The type of the amendment : add/modify/delete.
     *
     * @var string
     *
     * @ORM\Column(name="type")
     * @Assert\NotBlank
     * @Assert\Choice(callback = "getTypesValues")
     */
    private $type;

    /**
     * The contribution.
     *
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     * @Assert\NotBlank
     * @Assert\Type(type="string")
     */
    private $content;

    /**
     * The explanation.
     *
     * @var string
     *
     * @ORM\Column(name="explanation", type="text")
     * @Assert\NotBlank
     * @Assert\Type(type="string")
     */
    private $explanation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="meetingDate", type="date", nullable=true)
     * @Assert\Date
     */
    private $meetingDate;

    /**
     * The number of present.
     *
     * @var int
     *
     * @ORM\Column(name="number_present", type="integer", nullable=true)
     * @Assert\Type(type="integer")
     */
    private $numberOfPresent;

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

    public function __construct()
    {
        $this->meetingDate = new \DateTime();
    }

    /**
     * Available types.
     *
     * @return array
     */
    public static function getTypes()
    {
        return self::$types;
    }

    /**
     * Available values for types.
     *
     * @return array
     */
    public static function getTypesValues()
    {
        return array_keys(self::$types);
    }

    /**
     * Available natures.
     *
     * @return array
     */
    public static function getNatures()
    {
        return self::$natures;
    }

    /**
     * Available values for natures.
     *
     * @return array
     */
    public static function getNaturesValues()
    {
        return array_keys(self::$natures);
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
     * @return User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param User $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return Text
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param Text $text
     */
    public function setText(Text $text)
    {
        $this->text = $text;
    }

    /**
     * @return int
     */
    public function getStartLine()
    {
        return $this->startLine;
    }

    /**
     * @param int $startLine
     */
    public function setStartLine($startLine)
    {
        $this->startLine = $startLine;
    }

    /**
     * @return string
     */
    public function getHumanReadableType()
    {
        return self::$types[$this->type];
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
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
     * Set nature
     *
     * @param string $nature
     *
     * @return Amendment
     */
    public function setNature($nature)
    {
        $this->nature = $nature;

        return $this;
    }

    /**
     * Get nature
     *
     * @return string
     */
    public function getNature()
    {
        return $this->nature;
    }

    /**
     * @return string
     */
    public function getHumanReadableNature()
    {
        return self::$natures[$this->nature];
    }

    /**
     * Set explanation
     *
     * @param string $explanation
     *
     * @return Amendment
     */
    public function setExplanation($explanation)
    {
        $this->explanation = $explanation;

        return $this;
    }

    /**
     * Get explanation
     *
     * @return string
     */
    public function getExplanation()
    {
        return $this->explanation;
    }

    /**
     * Set organ
     *
     * @param \AppBundle\Entity\Organ\Organ $organ
     *
     * @return Amendment
     */
    public function setOrgan(\AppBundle\Entity\Organ\Organ $organ = null)
    {
        $this->organ = $organ;

        return $this;
    }

    /**
     * Get organ
     *
     * @return \AppBundle\Entity\Organ\Organ
     */
    public function getOrgan()
    {
        return $this->organ;
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
     * Set endLine
     *
     * @param integer $endLine
     *
     * @return Amendment
     */
    public function setEndLine($endLine)
    {
        $this->endLine = $endLine;

        return $this;
    }

    /**
     * Get endLine
     *
     * @return integer
     */
    public function getEndLine()
    {
        return $this->endLine;
    }
}
