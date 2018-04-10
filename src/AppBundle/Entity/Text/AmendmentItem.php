<?php

namespace AppBundle\Entity\Text;

use AppBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * The amendment items proposed to the congress.
 *
 * @ORM\Table(name="amendment_items")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Text\AmendmentItemRepository")
 */
class AmendmentItem
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
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=255)
     */
    private $reference;

    /**
     * The global amendment for which this item relates to
     *
     * @var \AppBundle\Entity\Text\AmendmentDeposit
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Text\AmendmentDeposit", inversedBy="items")
     * @Assert\NotNull
     */
    private $amendmentDeposit;

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
     * The number of favor votes
     *
     * @var int
     *
     * @ORM\Column(name="for_vote", type="integer")
     * @Assert\NotBlank
     * @Assert\Type(type="integer")
     */
    private $forVote = 0;

    /**
     * The number of favor votes
     *
     * @var int
     *
     * @ORM\Column(name="against_vote", type="integer")
     * @Assert\NotBlank
     * @Assert\Type(type="integer")
     */
    private $againstVote = 0;

    /**
     * The number of favor votes
     *
     * @var int
     *
     * @ORM\Column(name="abstention_vote", type="integer")
     * @Assert\NotBlank
     * @Assert\Type(type="integer")
     */
    private $abstentionVote = 0;

    /**
     * The number of ones that dont take part in the vote
     *
     * @var int
     *
     * @ORM\Column(name="dtpv_vote", type="integer")
     * @Assert\NotBlank
     * @Assert\Type(type="integer")
     */
    private $dtpvVote = 0;


    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return '#'.$this->getReference() ?: '';
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
    public function getHumanReadableType()
    {
        return self::$types[$this->type];
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
     * Set startLine
     *
     * @param integer $startLine
     *
     * @return AmendmentItem
     */
    public function setStartLine($startLine)
    {
        $this->startLine = $startLine;

        return $this;
    }

    /**
     * Get startLine
     *
     * @return integer
     */
    public function getStartLine()
    {
        return $this->startLine;
    }

    /**
     * Set endLine
     *
     * @param integer $endLine
     *
     * @return AmendmentItem
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

    /**
     * Set type
     *
     * @param string $type
     *
     * @return AmendmentItem
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return AmendmentItem
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set explanation
     *
     * @param string $explanation
     *
     * @return AmendmentItem
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
     * Set forVote
     *
     * @param integer $forVote
     *
     * @return AmendmentItem
     */
    public function setForVote($forVote)
    {
        $this->forVote = $forVote;

        return $this;
    }

    /**
     * Get forVote
     *
     * @return integer
     */
    public function getForVote()
    {
        return $this->forVote;
    }

    /**
     * Set againstVote
     *
     * @param integer $againstVote
     *
     * @return AmendmentItem
     */
    public function setAgainstVote($againstVote)
    {
        $this->againstVote = $againstVote;

        return $this;
    }

    /**
     * Get againstVote
     *
     * @return integer
     */
    public function getAgainstVote()
    {
        return $this->againstVote;
    }

    /**
     * Set abstentionVote
     *
     * @param integer $abstentionVote
     *
     * @return AmendmentItem
     */
    public function setAbstentionVote($abstentionVote)
    {
        $this->abstentionVote = $abstentionVote;

        return $this;
    }

    /**
     * Get abstentionVote
     *
     * @return integer
     */
    public function getAbstentionVote()
    {
        return $this->abstentionVote;
    }

    /**
     * Set dtpvVote
     *
     * @param integer $dtpvVote
     *
     * @return AmendmentItem
     */
    public function setDtpvVote($dtpvVote)
    {
        $this->dtpvVote = $dtpvVote;

        return $this;
    }

    /**
     * Get dtpvVote
     *
     * @return integer
     */
    public function getDtpvVote()
    {
        return $this->dtpvVote;
    }

    /**
     * Set amendment
     *
     * @param \AppBundle\Entity\Text\AmendmentDeposit $amendmentDeposit
     *
     * @return AmendmentItem
     */
    public function setAmendmentDeposit(\AppBundle\Entity\Text\AmendmentDeposit $amendmentDeposit = null)
    {
        $this->amendmentDeposit = $amendmentDeposit;

        return $this;
    }

    /**
     * Get amendment
     *
     * @return \AppBundle\Entity\Text\AmendmentDeposit
     */
    public function getAmendmentDeposit()
    {
        return $this->amendmentDeposit;
    }

    /**
     * Set text
     *
     * @param \AppBundle\Entity\Text\Text $text
     *
     * @return AmendmentItem
     */
    public function setText(\AppBundle\Entity\Text\Text $text = null)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return \AppBundle\Entity\Text\Text
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set reference
     *
     * @param string $reference
     *
     * @return AmendmentItem
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }
}
