<?php

namespace AppBundle\Entity\Vote;

use Doctrine\ORM\Mapping as ORM;


/**
 * IndividualOrganTextVote
 * People voting in an individual manner through an organ
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Vote\IndividualOrganTextVoteRepository")
 */
class IndividualOrganTextVote
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
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Text\TextGroup")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    protected $textGroup;

    /**
     * @var \stdClass
     *
     *  @ORM\OneToMany(targetEntity="IndividualOrganTextVoteAgregation",
     *  mappedBy="individualOrganTextVote")
     *
     */
    private $textVoteAgregations;

    /**
     * @var integer
     *
     * @ORM\Column(name="voteAbstention", type="integer")
     */
    private $voteAbstention;

    /**
     * @var integer
     *
     * @ORM\Column(name="voteNotTakingPart", type="integer")
     */
    private $voteNotTakingPart;

    /**
     * @var \stdClass
     *
     *  @ORM\ManyToOne(targetEntity="AppBundle\Entity\Organ\Organ")
     *  
     */
    private $organ;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Adherent")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $author;

    public function __construct(Organ $organ, Adherent $author, TextGroup $textGroup)
    {
        $this->organ = $organ;
        $this->author = $author;
        $this->textGroup = $textGroup;

        foreach ($textGroup as $text)
        {
            $textVoteAgregations[] = new IndividualTextVoteAgregation($text, $textGroup, $this);
        }
        
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
     * Set textVoteAgregations
     *
     * @param \stdClass $textVoteAgregations
     * @return IndividualOrganTextVote
     */
    public function setTextVoteAgregations($textVoteAgregations)
    {
        $this->textVoteAgregations = $textVoteAgregations;

        return $this;
    }

    /**
     * Get textVoteAgregations
     *
     * @return \stdClass 
     */
    public function getTextVoteAgregations()
    {
        return $this->textVoteAgregations;
    }

    /**
     * Set voteAbstention
     *
     * @param integer $voteAbstention
     * @return IndividualOrganTextVote
     */
    public function setVoteAbstention($voteAbstention)
    {
        $this->voteAbstention = $voteAbstention;

        return $this;
    }

    /**
     * Get voteAbstention
     *
     * @return integer 
     */
    public function getVoteAbstention()
    {
        return $this->voteAbstention;
    }

    /**
     * Set voteNotTakingPart
     *
     * @param integer $voteNotTakingPart
     * @return IndividualOrganTextVote
     */
    public function setVoteNotTakingPart($voteNotTakingPart)
    {
        $this->voteNotTakingPart = $voteNotTakingPart;

        return $this;
    }

    /**
     * Get voteNotTakingPart
     *
     * @return integer 
     */
    public function getVoteNotTakingPart()
    {
        return $this->voteNotTakingPart;
    }

    /**
     * Set organ
     *
     * @param \stdClass $organ
     * @return IndividualOrganTextVote
     */
    public function setOrgan($organ)
    {
        $this->organ = $organ;

        return $this;
    }

    /**
     * Get organ
     *
     * @return \stdClass 
     */
    public function getOrgan()
    {
        return $this->organ;
    }

    /**
     * Set author
     *
     * @param \stdClass $author
     * @return IndividualOrganTextVote
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
}
