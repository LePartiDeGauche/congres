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
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="general_vote_id", referencedColumnName="id")
     *
     */
    protected $vote;

    /**
     * Set vote
     *
     * @param  \AppBundle\Entity\User $vote
     * @return GeneralContributions
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
