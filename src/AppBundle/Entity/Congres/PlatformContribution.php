<?php

namespace AppBundle\Entity\Congres;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlatformContribution
 *
 *  @ORM\Entity(repositoryClass="AppBundle\Entity\Congres\PlatformContributionRepository")
 *
 */
final class PlatformContribution extends Contribution
{
    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="platform_vote_id", referencedColumnName="id")
     *
     */
    protected $vote;

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
}
