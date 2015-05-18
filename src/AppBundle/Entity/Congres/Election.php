<?php

namespace AppBundle\Entity\Congres;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Election.
 *
 * @ORM\Table(name="election")
 * @ORM\Entity
 */
class Election
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
     * The type of the Election.
     *
     * @var \AppBundle\Entity\Congres\ElectionGroup
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Congres\ElectionGroup")
     * @Assert\NotNull
     */
    private $electionGroup;

    /**
     * The status of the election, open or closed.
     *
     * @var bool
     *
     * @ORM\Column(name="status")
     * @Assert\NotBlank
     */
    private $status;
}