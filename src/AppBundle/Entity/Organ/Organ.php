<?php

namespace AppBundle\Entity\Organ;

use Doctrine\ORM\Mapping as ORM;

/**
 * Organ
 *
 * @ORM\Table(name="organ")
 * @ORM\Entity
 */
class Organ
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
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="OrganType", inversedBy="organs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $organType;


    /**
     * @var \stdClass
     * parents organ on the hierarchie.
     * example : a "comité" parent is commission départementale
     * @ORM\ManyToMany(targetEntity="Organ", 
     * inversedBy="subOrgans")
     */
    private $parentOrgans;   


    /**
     * @var \stdClass
     * attached sub organs on the hierarchy.
     * example : several "comité" are attache to a commission départementale
     * example : Commité is attached To Comité Départementale
     * @ORM\ManyToMany(targetEntity="Organ", 
     * mappedBy="parentOrgans")
     */
    private $subOrgans;

    /**
     * @var \stdClass
     *
     * @ORM\OneToMany(targetEntity="OrganParticipation", mappedBy="organ",
     * cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $participants;


    /**
     * @var \stdClass
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AdherentResponsability", mappedBy="designatedByOrgan",
     * cascade={"persist", "remove", "merge"})
     */
    private $designatedParticipants;

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
     * @return Organ
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
     * Set description
     *
     * @param string $description
     * @return Organ
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set organType
     *
     * @param \stdClass $organType
     * @return Organ
     */
    public function setOrganType($organType)
    {
        $this->organType = $organType;

        return $this;
    }

    /**
     * Get organType
     *
     * @return \stdClass 
     */
    public function getOrganType()
    {
        return $this->organType;
    }
}
