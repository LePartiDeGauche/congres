<?php

namespace AppBundle\Entity\Election;

use AppBundle\Entity\Adherent;
use AppBundle\Entity\Organ\Organ;
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
    const STATUS_OPEN = 'Election Ouverte';
    const STATUS_CLOSED = 'Election Fermée';

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
     * @var \AppBundle\Entity\Election\ElectionGroup
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Election\ElectionGroup")
     * @Assert\NotNull
     */
    private $electionGroup;

    /**
     * The localisation of the Election.
     *
     * @var \AppBundle\Entity\Organ\Organ
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Organ\Organ")
     */
    private $organ;

    /**
     * The status of the election, open or closed.
     *
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     * @Assert\NotBlank
     */
    private $status;

    /**
     * The responsable of the election.
     *
     * @var \AppBundle\Entity\Adherent
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Adherent")
     */
    private $electionResponsable;

    /**
     * @var string
     *
     * @ORM\Column(name="raw_content", type="text")
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
     * @return ElectionGroup
     */
    public function getElectionGroup()
    {
        return $this->electionGroup;
    }

    /**
     * @param ElectionGroup $electionGroup
     */
    public function setElectionGroup(ElectionGroup $electionGroup)
    {
        $this->electionGroup = $electionGroup;
    }

    /**
     * @return Organ
     */
    public function getOrgan()
    {
        return $this->organ;
    }

    /**
     * @param Organ $organ
     */
    public function setOrgan(Organ $organ)
    {
        $this->organ = $organ;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return Status
     */
    public function setStatus($status)
    {
        if (!in_array($status, array(
            self::STATUS_OPEN,
            self::STATUS_CLOSED,

        ))) {
            throw new \InvalidArgumentException('Invalid status');
        }

        $this->status = $status;

        return $this;
    }

    /**
     * @return Adherent
     */
    public function getElectionResponsable()
    {
        return $this->electionResponsable;
    }

    /**
     * @param Adherent $electionResponsable
     */
    public function setElectionResponsable(Adherent $electionResponsable)
    {
        $this->electionResponsable = $electionResponsable;
    }

    /**
     * @return Result
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param Adherent $adherent
     */
    public function setResult(Adherent $adherent)
    {
        $this->result = $adherent;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return '#'.$this->id ?: '';
    }
}