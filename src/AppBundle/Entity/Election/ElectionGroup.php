<?php

namespace AppBundle\Entity\Election;

use AppBundle\Entity\Responsability;
use AppBundle\Entity\Organ\OrganType;
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
     * The type of the organ.
     *
     * @var \AppBundle\Entity\Organ\OrganType
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Organ\OrganType")
     */
    private $organType;

    /**
     * The responsabilities given by the election.
     *
     * @var \AppBundle\Entity\Responsability
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Responsability")
     */
    private $responsabilities;

    /**
     * @var Responsability The responsability in charge of managing the election
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Responsability")
     */
    private $responsableResponsability;

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
     * @return OrganType
     */
    public function getOrganType()
    {
        return $this->organType;
    }

    /**
     * @param OrganType $organType
     */
    public function setOrganType(OrganType $organType)
    {
        $this->organType = $organType;
    }

    /**
     * @return Responsability
     */
    public function getResponsabilities()
    {
        return $this->responsabilities;
    }

    /**
     * @param Responsability $responsabilities
     */
    public function setResponsabilities(Responsability $responsabilities)
    {
        $this->responsabilities = $responsabilities;
    }

    /**
     * @return Responsability
     */
    public function getResponsableResponsability()
    {
        return $this->responsableResponsability;
    }

    /**
     * @param Responsability $responsableResponsability
     */
    public function setResponsableResponsability(Responsability $responsableResponsability)
    {
        $this->responsableResponsability = $responsableResponsability;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}
