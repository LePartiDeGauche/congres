<?php

namespace AppBundle\Entity\Congres;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Election.
 *
 * @ORM\Table(name="election")
 * @ORM\Entity
 */
class Election
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
     * The type of the Election.
     *
     * @var \AppBundle\Entity\Congres\ElectionGroup
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Congres\ElectionGroup")
     * @Assert\NotNull
     */
    private $electionGroup;

    /**
     * The status of the election, open or closed.
     *
     * @var bool
     *
     * @ORM\Column(name="status")
     * @Assert\NotBlank
     */
    private $status;

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
     * @return ElectionGroup
     */
    public function getElectionGroup()
    {
        return $this->$electionGroup;
    }

    /**
     * @param ElectionGroup $electionGroup
     */
    public function setElectionGroup(ElectionGroup $electionGroup)
    {
        $this->electionGroup = $electionGroup;
    }

    /**
     * @return bool
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
}