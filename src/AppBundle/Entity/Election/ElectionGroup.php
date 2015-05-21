<?php

namespace AppBundle\Entity\Congres;

use AppBundle\Entity\Adherent;
use AppBundle\Entity\Responsability;
use AppBundle\Entity\Organ\Organ;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Type of Election.
 *
 * @ORM\Table(name="election_group")
 * @ORM\Entity
 */
class ElectionGroup
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
     * The name of the Election.
     *
     * @var string
     *
     * @ORM\Column(name="name")
     * @Assert\NotBlank
     */
    private $name;

    /**
     * The organ.
     *
     * @var \AppBundle\Entity\Organ\Organ
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Organ\Organ")
     */
    private $organ;

    /**
     * The responsable of the election.
     *
     * @var \AppBundle\Entity\Adherent
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Adherent")
     */
    private $electionResponsable;

    /**
     * The responsabilities given by the election.
     *
     * @var \AppBundle\Entity\Responsability
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Responsability")
     */
    private $electionResponsabilities;

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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return Organ
     */
    public function getOrgan(Organ $organ)
    {
        return $this->$organ;
    }

    /**
     * @param Organ $organ
     */
    public function setOrgan(Organ $organ)
    {
        $this->organ = $organ;
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
     * @return Responsability
     */
    public function getElectionResponsabilities()
    {
        return $this->electionResponsabilities;
    }

    /**
     * @param Responsability $electionResponsabilities
     */
    public function setElectionResponsabilities(Responsability $electionResponsabilities)
    {
        $this->electionResponsabilities = $electionResponsabilities;
    }
}