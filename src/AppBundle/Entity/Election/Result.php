<?php

namespace AppBundle\Entity\Election;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Result.
 *
 * @ORM\Table(name="result")
 * @ORM\Entity
 */
class Result
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Election\Election
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Election\Election")
     */
    private $election;

    /**
     * @var \AppBundle\Entity\Election\Election
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Election\Election")
     */
    private $result;

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
     * Set id.
     *
     * @return int
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Election
     */
    public function getElection()
    {
        return $this->election;
    }

    /**
     * @param Election $election
     */
    public function setElection(Election $election)
    {
        $this->election = $election;
    }

    /**
     * @return Result
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param Result $result
     */
    public function setResult(Result $result)
    {
        $this->result = $result;
    }

}
