<?php

namespace AppBundle\Entity\Congres;

use Doctrine\ORM\Mapping as ORM;

/**
 * ThematicContribution
 *
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Congres\ThematicContributionRepository")
 */
final class ThematicContribution extends Contribution
{

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinTable(name="thematic_votes")
     *
     */
    protected $votes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->votes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add votes
     *
     * @param \AppBundle\Entity\User $votes
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
