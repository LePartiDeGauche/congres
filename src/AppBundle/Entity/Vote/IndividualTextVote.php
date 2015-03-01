<?php

namespace AppBundle\Entity\Vote;

use Doctrine\ORM\Mapping as ORM;

/**
 * IndividualTextVote
 *
 * @ORM\Table(name="individual_text_vote")
 * @ORM\Entity
 */
class IndividualTextVote
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="vote", type="string", length=50)
     */
    private $vote;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Adherent")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Text\Text", inversedBy="adherentVotes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $text;


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
     * Set date
     *
     * @param \DateTime $date
     * @return IndividualTextVote
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set vote
     *
     * @param string $vote
     * @return IndividualTextVote
     */
    public function setVote($vote)
    {
        $this->vote = $vote;

        return $this;
    }

    /**
     * Get vote
     *
     * @return string 
     */
    public function getVote()
    {
        return $this->vote;
    }

    /**
     * Set author
     *
     * @param \stdClass $author
     * @return IndividualTextVote
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
     * Set text
     *
     * @param \stdClass $text
     * @return IndividualTextVote
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return \stdClass 
     */
    public function getText()
    {
        return $this->text;
    }
}
