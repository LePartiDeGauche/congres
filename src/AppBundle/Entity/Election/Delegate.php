<?php

namespace AppBundle\Entity\Congres;

use AppBundle\Entity\Adherent;
use AppBundle\Entity\Organ\Organ;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Delegate for the congress.
 *
 * @ORM\Table(name="delegate")
 * @ORM\Entity
 */
class Delegate
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
     * The delegate.
     *
     * @var \AppBundle\Entity\Adherent
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Adherent")
     */
    private $adherent;

    /**
     * The organ concerned by the delegate.
     *
     * @var \AppBundle\Entity\Organ\Organ
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Organ\Organ")
     */
    private $organ;


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
     * @return Adherent
     */
    public function getAdherent()
    {
        return $this->$adherent;
    }

    /**
     * @param Adherent $adherent
     */
    public function setAdherent(Adherent $adherent)
    {
        $this->adherent = $adherent;
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
}