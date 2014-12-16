<?php

namespace AppBundle\Entity\Congres;

use Doctrine\ORM\Mapping as ORM;

/**
 * ThematicContributions
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Congres\ThematicContributionsRepository")
 */
class ThematicContributions extends Contributions
{

    /**
     * @var integer
     *
     * @ORM\Column(name="vote", type="integer")
     * FIXME
     */
    private $vote;


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
     * Set vote
     *
     * @param integer $vote
     * @return ThematicContributions
     */
    public function setVote($vote)
    {
        $this->vote = $vote;

        return $this;
    }

    /**
     * Get vote
     *
     * @return integer 
     */
    public function getVote()
    {
        return $this->vote;
    }
}
