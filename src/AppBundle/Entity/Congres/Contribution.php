<?php

namespace AppBundle\Entity\Congres;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use \DateTime as DateTime;

/**
 * @ORM\Table(name="contributions")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Congres\ContributionRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="contribution_type", type="string")
 * @ORM\DiscriminatorMap({"general" = "GeneralContribution",
 *                        "thematic" = "ThematicContribution",
 *                        "statute" = "StatuteContribution"})
 */
abstract class Contribution
{
    const STATUS_SIGNATURES_CLOSED = 'signatures closed';
    const STATUS_REJECTED = 'rejected contribution';
    const STATUS_SIGNATURES_OPEN = 'signatures open';
    const STATUS_NEW = 'new contribution';

    const DEPOSIT_TYPE_INDIVIDUAL = 'individual';
    const DEPOSIT_TYPE_SEN = 'SEN';
    const DEPOSIT_TYPE_COMMISSION = 'commission';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * The author of the contribution.
     *
     * @var \AppBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     *
     * @Assert\NotNull
     */
    protected $author;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     *
     * @Assert\NotNull
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     *
     * @Assert\NotNull
     */
    protected $status;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="submissionDate", type="datetime")
     *
     * @Assert\NotNull
     */
    protected $submissionDate;

    /**
     * @var string
     *
     * @ORM\Column(name="deposit_type", type="string", length=255)
     */
    protected $depositTypeValue;

    /**
     * Constructor.
     *
     * @param \AppBundle\Entity\User $author The author of the contribution.
     */
    public function __construct(\AppBundle\Entity\User $author = null)
    {
        $this->setAuthor($author);
        $this->setStatus(self::STATUS_NEW);
        $this->setSubmissionDate(new DateTime());
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
     * Set author.
     *
     * @param \AppBundle\Entity\User $author
     *
     * @return Contribution
     */
    public function setAuthor(\AppBundle\Entity\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author.
     *
     * @return \AppBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return Contribution
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content.
     *
     * @param string $content
     *
     * @return Contribution
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set status.
     *
     * @param string $status
     *
     * @return Contribution
     */
    public function setStatus($status)
    {
        if (!in_array($status, array(
            self::STATUS_SIGNATURES_OPEN,
            self::STATUS_SIGNATURES_CLOSED,
            self::STATUS_REJECTED,
            self::STATUS_NEW,
        ))) {
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

    /**
     * Set Submission Date
     *
     * @param DateTime $datetime
     *
     * @return Contribution
     */
    public function setSubmissionDate($datetime) {
        if (is_null($datetime)) {
            $datetime = new DateTime();
        }
        $this->submissionDate = $datetime;
        return $this;
    }

    /**
     * Get submission date
     *
     * @return DateTime
     */
    public function getSubmissionDate() {
        return $this->submissionDate;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Contribution
     */
    public function setDepositTypeValue($type = null)
    {
        $this->depositTypeValue = $type;

        return $this;
    }

    /**
     * Get type value
     *
     * @return string
     */
    public function getDepositTypeValue()
    {
        return $this->depositTypeValue;
    }

    /**
     * Get type

     * @return string
     */
    public function getDepositType()
    {
        $depositTypeValue = $this->getDepositTypeValue();

        if (!isset($depositTypeValue)) {
            return self::DEPOSIT_TYPE_INDIVIDUAL;
        } elseif ($depositTypeValue == self::DEPOSIT_TYPE_SEN) {
            return self::DEPOSIT_TYPE_SEN;
        } elseif ($depositTypeValue == self::DEPOSIT_TYPE_INDIVIDUAL) {
            return self::DEPOSIT_TYPE_INDIVIDUAL;
        } else {
            return self::DEPOSIT_TYPE_COMMISSION;
        }
    }

    public function setDepositType($value)
    {
        if (in_array($value, array(self::DEPOSIT_TYPE_INDIVIDUAL,
    self::DEPOSIT_TYPE_SEN, self::DEPOSIT_TYPE_COMMISSION))) {
            $this->depositType = $value;
        } else {
            $this->depositType = self::DEPOSIT_TYPE_INDIVIDUAL;
        }
        return $this;
    }

}
