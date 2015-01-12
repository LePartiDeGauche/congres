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
class Instance
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * The collection of user members of the instance.
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Adherent", mappedBy="instances")
     * @ORM\JoinTable(name="adherents_instances")
     */
    private $adherents;

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
        $this->adherents[] = $adherents;
        $adherent->addInstance($this);

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
        $adherent->removeElement($this);
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
}
