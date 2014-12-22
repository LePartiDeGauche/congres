<?php

namespace AppBundle\Entity\Congres;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlatformContributions
 *
 *  @ORM\Entity(repositoryClass="AppBundle\Entity\Congres\PlatformContributionsRepository")
 * 
 */
class PlatformContributions extends Contributions
{
    /**
     * @var 
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="platform_vote_id", referencedColumnName="id")
     * 
     */
    protected $vote;

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
     * @return PlatformContributions
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
     * @return PlatformContributions
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
     * Set vote
     *
     * @param \AppBundle\Entity\User $vote
     * @return PlatformContributions
     */
    public function setVote(\AppBundle\Entity\User $vote = null)
    {
        $this->vote = $vote;

        return $this;
    }

    /**
     * Get vote
     *
     * @return \AppBundle\Entity\User 
     */
    public function getVote()
    {
        return $this->vote;
    }

    /**
     * Set status
     *
     * @param \AppBundle\Entity\Congres\ContributionStatus $status
     * @return PlatformContributions
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
