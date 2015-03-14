<?php

namespace AppBundle\Entity\Event;

use Doctrine\ORM\Mapping as ORM;

/**
 * SleepingSpot
 *
 * @ORM\Table(name="sleeping_spot")
 * @ORM\Entity
 */
class SleepingSpot
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
     * @ORM\ManyToOne(targetEntity="SleepingSite", inversedBy="sleepingSpots")
     * @ORM\JoinColumn(name="sleeping_site", nullable=false)
     */
    private $sleepingSite;


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
     * @return SleepingSpot
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
     * @return SleepingSpot
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
     * Set sleepingSite
     *
     * @param \AppBundle\Entity\Event\SleepingSite $sleepingSite
     * @return SleepingSpot
     */
    public function setSleepingSite(\AppBundle\Entity\Event\SleepingSite $sleepingSite)
    {
        $this->sleepingSite = $sleepingSite;

        return $this;
    }

    /**
     * Get sleepingSite
     *
     * @return \AppBundle\Entity\Event\SleepingSite 
     */
    public function getSleepingSite()
    {
        return $this->sleepingSite;
    }
}
