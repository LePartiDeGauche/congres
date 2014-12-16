<?php

namespace AppBundle\Entity\Congres;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlatformContributions
 *
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Congres\PlatformContributionsRepository")
 */
class PlatformContributions extends Contributions
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
     * @var 
     *
     * @ORM\ManyToOne(targetEntity="Users")
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
     * @param \AppBundle\Entity\Congres\Users $vote
     * @return PlatformContributions
     */
    public function setVote(\AppBundle\Entity\Congres\Users $vote = null)
    {
        $this->vote = $vote;

        return $this;
    }

    /**
     * Get vote
     *
     * @return \AppBundle\Entity\Congres\Users 
     */
    public function getVote()
    {
        return $this->vote;
    }
}
