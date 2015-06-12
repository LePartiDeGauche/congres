<?php

namespace AppBundle\Entity\Election;

use AppBundle\Entity\Adherent;
use AppBundle\Entity\Organ\Organ;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Election.
 *
 * @ORM\Table(name="election")
 * @ORM\Entity(repositoryClass="ElectionRepository")
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
    private $group;

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
     * @var int
     *
     * @ORM\Column(type="smallint")
     * @Assert\Range(min=1)
     */
    private $numberOfElected;

    /**
     * The responsable of the election.
     *
     * @var \AppBundle\Entity\Adherent
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Adherent")
     */
    private $responsable;

    /**
     * @var Adherent[]
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Adherent")
     * @Assert\Expression(
     *     "this.getElected().count() <= this.getNumberOfElected()",
     *     message="Trop d'élus selectionnés",
     *     groups={"report_election"}
     * )
     */
    private $elected;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_valid", type="boolean")
     */
    private $isValid;

    /**
     * @return string
     */
    public function __toString()
    {
        return '#'.$this->id ?: '';
    }

    public function __construct()
    {
        $this->elected = new ArrayCollection();
    }

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
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param ElectionGroup $group
     */
    public function setGroup(ElectionGroup $group)
    {
        $this->group = $group;
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
    public function getResponsable()
    {
        return $this->responsable;
    }

    /**
     * @param Adherent $responsable
     */
    public function setResponsable(Adherent $responsable)
    {
        $this->responsable = $responsable;
    }

    /**
     * @return int
     */
    public function getNumberOfElected()
    {
        return $this->numberOfElected;
    }

    /**
     * @param int $numberOfElected
     *
     * @return Election
     */
    public function setNumberOfElected($numberOfElected)
    {
        $this->numberOfElected = $numberOfElected;

        return $this;
    }

    /**
     * @return Adherent[]
     */
    public function getElected()
    {
        return $this->elected;
    }

    /**
     * @return string
     */
    public function getElectedNames()
    {
        return join(', ', $this->elected->toArray());
    }

    /**
     * @param Adherent[] $elected
     *
     * @return $this
     */
    public function setElected($elected)
    {
        $this->elected = $elected;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isIsValid()
    {
        return $this->isValid;
    }

    /**
     * @param boolean $isValid
     */
    public function setIsValid($isValid)
    {
        $this->isValid = $isValid;
    }

    public function getElectedEmail()
    {
        return join(', ', $this->elected->map(function (Adherent $elected) {
            return $elected->getEmail();
        })->toArray());
    }

}
