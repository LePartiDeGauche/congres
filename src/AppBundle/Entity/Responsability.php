<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Instance
 *
 * @ORM\Table(name="instances",
 * indexes ={@ORM\Index(name="name", columns={"name"})})
 * @ORM\Entity
 */
class Responsability
{
    const INSTANCE_CN = 'Conseil National';
    const INSTANCE_BN = 'Bureau National';
    const INSTANCE_SN = 'Secrétariat National';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="date", type="date", nullable=true)
     */
    private $electionDate;

    /**
     * The collection of user members of the instance.
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AdherentResponsability", mappedBy="responsability")
     */
    private $adherentResponsabilities;

    /**
     * The collection of user members of the instance.
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Organ\OrganType",
     * inversedBy="participationAllowedBy")
     */
    private $allowsParticipations;

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
     * Set name
     *
     * @param  string   $name
     * @return Instance
     */
    public function setName($name)
    {
        if (!in_array($name, array(
            self::INSTANCE_SN,
            self::INSTANCE_BN,
            self::INSTANCE_CN,
        ))) {
        throw new \InvalidArgumentException("Invalid status");
        }

        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->adherents = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add adherents
     *
     * @param  \AppBundle\Entity\Adherent $adherent
     * @return Instance
     */
    public function addAdherent(\AppBundle\Entity\Adherent $adherent)
    {
        $this->adherents->add($adherent);

        return $this;
    }

    /**
     * Remove adherents
     *
     * @param \AppBundle\Entity\Adherent $adherents
     */
    public function removeAdherent(\AppBundle\Entity\Adherent $adherent)
    {
        $this->adherents->removeElement($adherent);
    }

    /**
     * Get adherents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdherents()
    {
        return $this->adherents;
    }

    /**
     * Set election date
     *
     * @param  \DateTime $date
     * @return Instance
     */
    public function setElectionDate(\DateTime $date)
    {
        $this->electionDate = $date;

        return $this;
    }

    /**
     * Get election date
     *
     * @return \DateTime
     */
    public function getElectionDate()
    {
        return $this->electionDate;
    }

    public function __toString()
    {
        return $this->name;
    }
}
