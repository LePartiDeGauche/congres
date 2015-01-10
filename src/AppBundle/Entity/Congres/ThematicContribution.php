<?php

namespace AppBundle\Entity\Congres;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\User as User;

/**
 * ThematicContribution.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Congres\ThematicContributionRepository")
 */
class ThematicContribution extends Contribution
{
    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinTable(name="thematic_votes")
     */
    protected $votes;

    /**
     * Constructor.
     */
    public function __construct(\AppBundle\Entity\User $user = null)
    {
        parent::__construct($user);
        $this->votes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add votes.
     *
     * @param \AppBundle\Entity\User $votes
     *
     * @return ThematicContribution
     */
    public function addVote(User $votes)
    {
        $this->votes[] = $votes;

        return $this;
    }

    /**
     * Remove votes.
     *
     * @param AppBundle\Entity\User $votes
     */
    public function removeVote(User $votes)
    {
        $this->votes->removeElement($votes);
    }

    /**
     * Get votes.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVotes()
    {
        return $this->votes;
    }
}
