<?php

namespace AppBundle\Entity\Text;

use Doctrine\ORM\Mapping as ORM;

/**
 * Text.
 *
 * @ORM\Table(name="text")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Text\TextRepository")
 */
class Text
{
    const STATUS_NEW = 'new';
    const STATUS_PROPOSED = 'proposed';
    const STATUS_VOTING = 'voting';
    const STATUS_ADOPTED = 'adopted';
    const STATUS_REJECTED = 'rejected';
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Adherent")
     * @ORM\JoinColumn(nullable=false)
     */
    private $depositor;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Adherent")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="author_info", type="string", length=255, nullable=true)
     */
    private $authorInfo;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Organ\Organ")
     */
    private $organ;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="raw_content", type="text")
     */
    private $rawContent;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @var \stdClass
     *
     * @ORM\OneToMany(
     * targetEntity="AppBundle\Entity\Vote\IndividualTextVote",
     * mappedBy="text")
     */
    private $adherentVotes;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="organ_vote", type="object")
     */
    private $organVotes;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="TextGroup", inversedBy="texts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $textGroup;

    /**
     * @var \stdClass
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Vote\IndividualTextVoteAgregation", mappedBy="text",
     * cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $individualVoteAgregations;

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
     * @param \stdClass $author
     *
     * @return Text
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author.
     *
     * @return \stdClass
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set adherentGroup.
     *
     * @param \stdClass $adherentGroup
     *
     * @return Text
     */
    public function setAdherentGroup($adherentGroup)
    {
        $this->adherentGroup = $adherentGroup;

        return $this;
    }

    /**
     * Get adherentGroup.
     *
     * @return \stdClass
     */
    public function getAdherentGroup()
    {
        return $this->adherentGroup;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return Text
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
     * Set status.
     *
     * @param string $status
     *
     * @return Text
     */
    public function setStatus($status)
    {
        if (!in_array($status, array(
            self::STATUS_NEW,
            self::STATUS_PROPOSED,
            self::STATUS_VOTING,
            self::STATUS_ADOPTED,
            self::STATUS_REJECTED,
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
     * Set adherentVote.
     *
     * @param \stdClass $adherentVote
     *
     * @return Text
     */
    public function setAdherentVote($adherentVote)
    {
        $this->adherentVote = $adherentVote;

        return $this;
    }

    /**
     * Get adherentVote.
     *
     * @return \stdClass
     */
    public function getAdherentVote()
    {
        return $this->adherentVote;
    }

    /**
     * Set adherentGroupVote.
     *
     * @param \stdClass $adherentGroupVote
     *
     * @return Text
     */
    public function setAdherentGroupVote($adherentGroupVote)
    {
        $this->adherentGroupVote = $adherentGroupVote;

        return $this;
    }

    /**
     * Get adherentGroupVote.
     *
     * @return \stdClass
     */
    public function getAdherentGroupVote()
    {
        return $this->adherentGroupVote;
    }

    /**
     * Set textGroup.
     *
     * @param \stdClass $textGroup
     *
     * @return Text
     */
    public function setTextGroup($textGroup)
    {
        $this->textGroup = $textGroup;

        return $this;
    }

    /**
     * Get textGroup.
     *
     * @return \stdClass
     */
    public function getTextGroup()
    {
        return $this->textGroup;
    }
    /**
     * Constructor.
     */
    public function __construct(\AppBundle\Entity\Adherent $author = null)
    {
        $this->setDepositor($author);
        $this->setAuthor($author);
        $this->setStatus(self::STATUS_NEW);
        $this->adherentVotes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set organVotes.
     *
     * @param \stdClass $organVotes
     *
     * @return Text
     */
    public function setOrganVotes($organVotes)
    {
        $this->organVotes = $organVotes;

        return $this;
    }

    /**
     * Get organVotes.
     *
     * @return \stdClass
     */
    public function getOrganVotes()
    {
        return $this->organVotes;
    }

    /**
     * Set organ.
     *
     * @param \AppBundle\Entity\Organ\Organ $organ
     *
     * @return Text
     */
    public function setOrgan(\AppBundle\Entity\Organ\Organ $organ)
    {
        $this->organ = $organ;

        return $this;
    }

    /**
     * Get organ.
     *
     * @return \AppBundle\Entity\Organ\Organ
     */
    public function getOrgan()
    {
        return $this->organ;
    }

    /**
     * Add adherentVotes.
     *
     * @param \AppBundle\Entity\Vote\IndividualTextVote $adherentVotes
     *
     * @return Text
     */
    public function addAdherentVote(\AppBundle\Entity\Vote\IndividualTextVote $adherentVotes)
    {
        $this->adherentVotes[] = $adherentVotes;

        return $this;
    }

    /**
     * Remove adherentVotes.
     *
     * @param \AppBundle\Entity\Vote\IndividualTextVote $adherentVotes
     */
    public function removeAdherentVote(\AppBundle\Entity\Vote\IndividualTextVote $adherentVotes)
    {
        $this->adherentVotes->removeElement($adherentVotes);
    }

    /**
     * Get adherentVotes.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdherentVotes()
    {
        return $this->adherentVotes;
    }

    /**
     * Set rawContent.
     *
     * @param string $rawContent
     *
     * @return Text
     */
    public function setRawContent($rawContent)
    {
        $this->rawContent = $rawContent;

        return $this;
    }

    /**
     * Get rawContent.
     *
     * @return string
     */
    public function getRawContent()
    {
        return $this->rawContent;
    }

    /**
     * Add individualVoteAgregations.
     *
     * @param \AppBundle\Entity\Vote\IndividualTextVoteAgregation $individualVoteAgregations
     *
     * @return Text
     */
    public function addIndividualVoteAgregation(\AppBundle\Entity\Vote\IndividualTextVoteAgregation $individualVoteAgregations)
    {
        $this->individualVoteAgregations[] = $individualVoteAgregations;

        return $this;
    }

    /**
     * Remove individualVoteAgregations.
     *
     * @param \AppBundle\Entity\Vote\IndividualTextVoteAgregation $individualVoteAgregations
     */
    public function removeIndividualVoteAgregation(\AppBundle\Entity\Vote\IndividualTextVoteAgregation $individualVoteAgregations)
    {
        $this->individualVoteAgregations->removeElement($individualVoteAgregations);
    }

    /**
     * Get individualVoteAgregations.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIndividualVoteAgregations()
    {
        return $this->individualVoteAgregations;
    }

    public function __toString()
    {
        return $this->title;
    }

    /**
     * Set depositor
     *
     * @param \AppBundle\Entity\Adherent $depositor
     *
     * @return Text
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
     * Set authorInfo
     *
     * @param string $authorInfo
     *
     * @return Text
     */
    public function setAuthorInfo($authorInfo)
    {
        $this->authorInfo = $authorInfo;

        return $this;
    }

    /**
     * Get authorInfo
     *
     * @return string
     */
    public function getAuthorInfo()
    {
        return $this->authorInfo;
    }
}
