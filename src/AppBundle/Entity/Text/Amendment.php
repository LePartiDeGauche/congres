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
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @Assert\NotNull
     */
    private $author;

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
     * @var \DateTime
     *
     * @ORM\Column(name="meetingDate", type="date", nullable=true)
     * @Assert\Date
     */
    private $meetingDate;

    /**
     * The number of present
     *
     * @var int
     *
     * @ORM\Column(name="number_present", type="integer", nullable=true)
     * @Assert\Type(type="integer")
     */
    private $numberOfPresent;


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
    public function setAuthor(User $author)
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
}

