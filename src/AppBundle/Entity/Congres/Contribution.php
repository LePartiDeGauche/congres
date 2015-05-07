<?php

namespace AppBundle\Entity\Congres;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="contributions")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Congres\ContributionRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="contribution_type", type="string")
 * @ORM\DiscriminatorMap({"general" = "GeneralContribution", "thematic" = "ThematicContribution"})
 */
abstract class Contribution
{
    const STATUS_SIGNATURES_CLOSED = 'signatures closed';
    const STATUS_SIGNATURES_OPEN = 'signatures open';
    const STATUS_NEW = 'new contribution';

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
     */
    protected $author;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    protected $content;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    protected $status;

    /**
     * Constructor.
     *
     * @param \AppBundle\Entity\User $author The author of the contribution.
     */
    public function __construct(\AppBundle\Entity\User $author = null)
    {
        $this->setAuthor($author);
        $this->setStatus(self::STATUS_NEW);
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
}
