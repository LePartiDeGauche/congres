<?php

namespace AppBundle\Entity\Election;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Adherent;

/**
 * ElectionResult
 *
 * @ORM\Table(name="election_result")
 * @ORM\Entity
 */
class ElectionResult
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
     * @var Election
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Election\Election")
     * @Assert\NotNull
     */
    private $election;

    /**
     * @var Adherent[]
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Adherent")
     * @Assert\NotNull
     */
    private $elected;

    /**
     * @var integer
     *
     * @ORM\Column(name="numberOfVote", type="integer")
     * @Assert\NotNull
     */
    private $numberOfVote;

    public function __toString()
    {
        return (string) $this->getElected();
    }

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
     * Set elected
     *
     * @param Adherent $elected
     *
     * @return ElectionResult
     */
    public function setElected(Adherent $elected)
    {
        $this->elected = $elected;

        return $this;
    }

    /**
     * Get elected
     *
     * @return Adherent
     */
    public function getElected()
    {
        return $this->elected;
    }

    /**
     * Set numberOfVote
     *
     * @param integer $numberOfVote
     *
     * @return ElectionResult
     */
    public function setNumberOfVote($numberOfVote)
    {
        $this->numberOfVote = $numberOfVote;

        return $this;
    }

    /**
     * Get numberOfVote
     *
     * @return integer
     */
    public function getNumberOfVote()
    {
        return $this->numberOfVote;
    }

    /**
     * Set election
     *
     * @param \AppBundle\Entity\Election\Election $election
     *
     * @return ElectionResult
     */
    public function setElection(\AppBundle\Entity\Election\Election $election = null)
    {
        $this->election = $election;

        return $this;
    }

    /**
     * Get election
     *
     * @return \AppBundle\Entity\Election\Election
     */
    public function getElection()
    {
        return $this->election;
    }
}
