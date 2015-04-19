<?php

namespace AppBundle\Entity\Text;

use Doctrine\ORM\Mapping as ORM;

/**
 * TextGroup
 *
 * @ORM\Table(name="text_group")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Text\TextGroupRepository")
 */
class TextGroup
{

    const VOTETYPE_COLLECTIVE = "collective";
    const VOTETYPE_INDIVIDUAL = "individual";

    const VOTEMODALITY_VALIDATION = "validation";
    const VOTEMODALITY_REFERENDUM = "referendum";

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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \stdClass
     *
     * @ORM\OneToMany(targetEntity="Text", mappedBy="textGroup",
     * cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $texts;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="submission_opening", type="datetime")
     */
    private $submissionOpening;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="submission_closing", type="datetime")
     */
    private $submissionClosing;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="vote_opening", type="datetime")
     */
    private $voteOpening;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="vote_closing", type="datetime")
     */
    private $voteClosing;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Adherent")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @var string
     * Collective vote or individual
     * @ORM\Column(name="vote_type", type="string", length=255)
     */
    private $voteType;

    /**
     * @var string
     * validation vote | referundum 
     * @ORM\Column(name="vote_modality", type="string", length=255)
     */
    private $voteModality;

    /**
     * @var \stdClass
     *
     * Only for collective vote
     *
     * @ORM\OneToMany(
     * targetEntity="AppBundle\Entity\Vote\OrganVoteRule",
     * mappedBy="textGroup",
     * cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $organVoteRules;

    /**
     * @var \stdClass
     *
     * Only for individual vote
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Vote\VoteRule", mappedBy="textGroup",
     * cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $voteRules;


    /**
     * @var integer
     *
     * @ORM\Column( type="integer")
     */
    // we could replace by rules based on responsability
    private $maxVotesByAdherent;



    /**
     * @var boolean
     *
      @ORM\Column(type="boolean")
     */
    private $isVisible;

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
     * Set name
     *
     * @param string $name
     * @return TextGroup
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return TextGroup
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
     * Set texts
     *
     * @param \stdClass $texts
     * @return TextGroup
     */
    public function setTexts($texts)
    {
        $this->texts = $texts;

        return $this;
    }

    /**
     * Get texts
     *
     * @return \stdClass 
     */
    public function getTexts()
    {
        return $this->texts;
    }

    /**
     * Set submissionOpening
     *
     * @param \DateTime $submissionOpening
     * @return TextGroup
     */
    public function setSubmissionOpening($submissionOpening)
    {
        $this->submissionOpening = $submissionOpening;

        return $this;
    }

    /**
     * Get submissionOpening
     *
     * @return \DateTime 
     */
    public function getSubmissionOpening()
    {
        return $this->submissionOpening;
    }

    /**
     * Set submissionClosing
     *
     * @param \DateTime $submissionClosing
     * @return TextGroup
     */
    public function setSubmissionClosing($submissionClosing)
    {
        $this->submissionClosing = $submissionClosing;

        return $this;
    }

    /**
     * Get submissionClosing
     *
     * @return \DateTime 
     */
    public function getSubmissionClosing()
    {
        return $this->submissionClosing;
    }

    /**
     * Set voteOpening
     *
     * @param \DateTime $voteOpening
     * @return TextGroup
     */
    public function setVoteOpening($voteOpening)
    {
        $this->voteOpening = $voteOpening;

        return $this;
    }

    /**
     * Get voteOpening
     *
     * @return \DateTime 
     */
    public function getVoteOpening()
    {
        return $this->voteOpening;
    }

    /**
     * Set voteClosing
     *
     * @param \DateTime $voteClosing
     * @return TextGroup
     */
    public function setVoteClosing($voteClosing)
    {
        $this->voteClosing = $voteClosing;

        return $this;
    }

    /**
     * Get voteClosing
     *
     * @return \DateTime 
     */
    public function getVoteClosing()
    {
        return $this->voteClosing;
    }

    /**
     * Set author
     *
     * @param \stdClass $author
     * @return TextGroup
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \stdClass 
     */
    public function getAuthor()
    {
        return $this->author;
    }


    /**
     * Set organTypeVoters
     *
     * @param \stdClass $organTypeVoters
     * @return TextGroup
     */
    public function setOrganTypeVoters($organTypeVoters)
    {
        $this->organTypeVoters = $organTypeVoters;

        return $this;
    }

    /**
     * Get organTypeVoters
     *
     * @return \stdClass 
     */
    public function getOrganTypeVoters()
    {
        return $this->organTypeVoters;
    }

    /**
     * Set voteRules
     *
     * @param \stdClass $voteRules
     * @return TextGroup
     */
    public function setVoteRules($voteRules)
    {
        $this->voteRules = $voteRules;

        return $this;
    }

    /**
     * Get voteRules
     *
     * @return \stdClass 
     */
    public function getVoteRules()
    {
        return $this->voteRules;
    }

    /**
     * Set responsabilityVoters
     *
     * @param \stdClass $responsabilityVoters
     * @return TextGroup
     */
    public function setResponsabilityVoters($responsabilityVoters)
    {
        $this->responsabilityVoters = $responsabilityVoters;

        return $this;
    }

    /**
     * Get responsabilityVoters
     *
     * @return \stdClass 
     */
    public function getResponsabilityVoters()
    {
        return $this->responsabilityVoters;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->texts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->organVoteRules = new \Doctrine\Common\Collections\ArrayCollection();
        $this->voteRules = new \Doctrine\Common\Collections\ArrayCollection();
        $this->isVisible = false;
    }
     
    public function __toString()
    {
        return $this->name;
    }

    /**
     * Set voteType
     *
     * @param string $voteType
     * @return TextGroup
     */
    public function setVoteType($voteType)
    {
        if (!in_array($voteType, array(
            self::VOTETYPE_COLLECTIVE,
            self::VOTETYPE_INDIVIDUAL,
        ))) {
            throw new \InvalidArgumentException('Invalid votetype');
        }
        $this->voteType = $voteType;

        return $this;
    }

    /**
     * Get voteType
     *
     * @return string 
     */
    public function getVoteType()
    {
        return $this->voteType;
    }

    /**
     * Set voteModality
     *
     * @param string $voteModality
     * @return TextGroup
     */
    public function setVoteModality($voteModality)
    {
        if (!in_array($voteModality, array(
            self::VOTEMODALITY_VALIDATION,
            self::VOTEMODALITY_REFERENDUM,
        ))) {
            throw new \InvalidArgumentException('Invalid votetype');
        }
        $this->voteModality = $voteModality;

        return $this;
    }

    /**
     * Get voteModality
     *
     * @return string 
     */
    public function getVoteModality()
    {
        return $this->voteModality;
    }

    /**
     * Add texts
     *
     * @param \AppBundle\Entity\Text\Text $texts
     * @return TextGroup
     */
    public function addText(\AppBundle\Entity\Text\Text $texts)
    {
        $this->texts[] = $texts;

        return $this;
    }

    /**
     * Remove texts
     *
     * @param \AppBundle\Entity\Text\Text $texts
     */
    public function removeText(\AppBundle\Entity\Text\Text $texts)
    {
        $this->texts->removeElement($texts);
    }

    /**
     * Add organVoteRules
     *
     * @param \AppBundle\Entity\Vote\OrganVoteRule $organVoteRules
     * @return TextGroup
     */
    public function addOrganVoteRule(\AppBundle\Entity\Vote\OrganVoteRule $organVoteRules)
    {
        $this->organVoteRules[] = $organVoteRules;

        return $this;
    }

    /**
     * Remove organVoteRules
     *
     * @param \AppBundle\Entity\Vote\OrganVoteRule $organVoteRules
     */
    public function removeOrganVoteRule(\AppBundle\Entity\Vote\OrganVoteRule $organVoteRules)
    {
        $this->organVoteRules->removeElement($organVoteRules);
    }

    /**
     * Get organVoteRules
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrganVoteRules()
    {
        return $this->organVoteRules;
    }

    /**
     * Add voteRules
     *
     * @param \AppBundle\Entity\Vote\VoteRule $voteRules
     * @return TextGroup
     */
    public function addVoteRule(\AppBundle\Entity\Vote\VoteRule $voteRules)
    {
        $this->voteRules[] = $voteRules;

        return $this;
    }

    /**
     * Remove voteRules
     *
     * @param \AppBundle\Entity\Vote\VoteRule $voteRules
     */
    public function removeVoteRule(\AppBundle\Entity\Vote\VoteRule $voteRules)
    {
        $this->voteRules->removeElement($voteRules);
    }

    /**
     * Set maxVotesByAdherent
     *
     * @param integer $maxVotesByAdherent
     * @return TextGroup
     */
    public function setMaxVotesByAdherent($maxVotesByAdherent)
    {
        $this->maxVotesByAdherent = $maxVotesByAdherent;

        return $this;
    }

    /**
     * Get maxVotesByAdherent
     *
     * @return integer 
     */
    public function getMaxVotesByAdherent()
    {
        return $this->maxVotesByAdherent;
    }

    /**
     * Set isVisible
     *
     * @param boolean $isVisible
     * @return TextGroup
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
}
