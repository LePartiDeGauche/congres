<?php

namespace AppBundle\Entity\Congres;

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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    private $adherent;

    /**
     * The organ concerned by the delegate.
     *
     * @var \AppBundle\Entity\Organ\Organ
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Organ\Organ")
     */
    private $organ;
}