<?php

namespace AppBundle\Entity\Vote;

use Doctrine\ORM\Mapping as ORM;

/**
 * ThresholdVoteRule
 *
 * @ORM\Table(name="threshold_voterule")
 * @ORM\Entity
 */
class ThresholdVoteRule extends VoteRule
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
     * @var integer
     *
     * @ORM\Column(name="threshold", type="integer")
     */
    private $threshold;


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
     * Set threshold
     *
     * @param integer $threshold
     * @return ThresholdVoteRule
     */
    public function setThreshold($threshold)
    {
        $this->threshold = $threshold;

        return $this;
    }

    /**
     * Get threshold
     *
     * @return integer 
     */
    public function getThreshold()
    {
        return $this->threshold;
    }
}
