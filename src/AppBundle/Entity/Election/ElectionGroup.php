<?php

namespace AppBundle\Entity\Congres;

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
}