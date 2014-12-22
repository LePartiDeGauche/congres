<?php

namespace AppBundle\Entity\Congres;

use Doctrine\ORM\Mapping as ORM;

/**
 * ThematicContributions
 *
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Congres\ThematicContributionsRepository")
 */
class ThematicContributions extends Contributions
{

    /**
     * @var integer
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinTable(name="thematic_votes")
     * 
     */
    protected $votes;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var \AppBundle\Entity\Congres\ContributionStatus
     */
    protected $status;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->votes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return ThematicContributions
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return ThematicContributions
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
     * Add votes
     *
     * @param \AppBundle\Entity\User $votes
     * @return ThematicContributions
     */
    public function addVote(\AppBundle\Entity\User $votes)
    {
        $this->votes[] = $votes;

        return $this;
    }

    /**
     * Remove votes
     *
     * @param \AppBundle\Entity\User $votes
     */
    public function removeVote(\AppBundle\Entity\User $votes)
    {
        $this->votes->removeElement($votes);
    }

    /**
     * Get votes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVotes()
    {
        return $this->votes;
    }

    /**
     * Set status
     *
     * @param \AppBundle\Entity\Congres\ContributionStatus $status
     * @return ThematicContributions
     */
    public function setStatus(\AppBundle\Entity\Congres\ContributionStatus $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \AppBundle\Entity\Congres\ContributionStatus 
     */
    public function getStatus()
    {
        return $this->status;
    }
}
