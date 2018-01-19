<?php

namespace AppBundle\Entity\Congres;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\User as User;
use AppBundle\Validator\Constraints as AppBundleAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ThematicContribution.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Congres\ThematicContributionRepository")
 */
class ThematicContribution extends Contribution
{
    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     *
     * @Assert\NotNull
     * @AppBundleAssert\FormatedLength(
     *     max=8200,
     *     maxMessage="Votre contribution ne doit pas dépasser les 8000 caractères (espaces compris)."
     * )
     */
    protected $content;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinTable(name="thematic_votes")
     */
    protected $votes;

    /**
     * Constructor.
     */
    public function __construct(User $user = null)
    {
        parent::__construct($user);
        $this->votes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add votes.
     *
     * @param User $votes
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
     * @param User $votes
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
