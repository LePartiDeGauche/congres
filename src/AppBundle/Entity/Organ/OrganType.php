<?php

namespace AppBundle\Entity\Organ;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrganType
 *
 * @ORM\Table(name="organ_type")
 * @ORM\Entity
 */
class OrganType
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
     * @var \stdClass
     *
     * @ORM\OneToMany(targetEntity="Organ", mappedBy="organType",
     * cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $organs;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=64)
     */
    private $type;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isUnique", type="boolean")
     */
    private $isUnique;

    /**
     * The collection of user members of the instance.
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Responsability",
     * mappedBy="allowsParticipations")
     */
    private $participationAllowedBy;


    public function __toString()
    {
        return $this->name;
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
     * Set name
     *
     * @param string $name
     * @return OrganType
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
     * Set organs
     *
     * @param \stdClass $organs
     * @return OrganType
     */
    public function setOrgans($organs)
    {
        $this->organs = $organs;

        return $this;
    }

    /**
     * Get organs
     *
     * @return \stdClass 
     */
    public function getOrgans()
    {
        return $this->organs;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return OrganType
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set isUnique
     *
     * @param boolean $isUnique
     * @return OrganType
     */
    public function setIsUnique($isUnique)
    {
        $this->isUnique = $isUnique;

        return $this;
    }

    /**
     * Get isUnique
     *
     * @return boolean 
     */
    public function getIsUnique()
    {
        return $this->isUnique;
    }
}
