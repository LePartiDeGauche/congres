<?php

namespace AppBundle\Entity\Congres;

use Doctrine\ORM\Mapping as ORM;

/**
 * GeneralContribution
 *
 *  @ORM\Entity(repositoryClass="AppBundle\Entity\Congres\GeneralContributionRepository")
 *
 */
class GeneralContribution extends Contribution
{
    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinTable(
     *     name="general_votes",
     *     joinColumns={@ORM\JoinColumn(name="contribution_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", unique=true)}
     * )
     *
     */
    protected $votes;

    /**
     * Constructor
     */
    public function __construct(\AppBundle\Entity\User $user = null)
    {
        parent::__construct($user);
        $this->votes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add votes
     *
     * @param  \AppBundle\Entity\User $votes
     * @return ThematicContribution
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
}
