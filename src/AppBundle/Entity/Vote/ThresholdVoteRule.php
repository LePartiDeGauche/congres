<?php

namespace AppBundle\Entity\Vote;

use Doctrine\ORM\Mapping as ORM;

/**
 * ThresholdVoteRule.
 *
 * @ORM\Table(name="threshold_voterule")
 * @ORM\Entity
 */
class ThresholdVoteRule extends VoteRule
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var int
     *
     * @ORM\Column(name="threshold", type="integer")
     */
    protected $threshold;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set threshold.
     *
     * @param int $threshold
     *
     * @return ThresholdVoteRule
     */
    public function setThreshold($threshold)
    {
        $this->threshold = $threshold;

        return $this;
    }

    /**
     * Get threshold.
     *
     * @return int
     */
    public function getThreshold()
    {
        return $this->threshold;
    }
}
