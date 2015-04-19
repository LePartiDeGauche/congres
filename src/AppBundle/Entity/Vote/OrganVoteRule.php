<?php

namespace AppBundle\Entity\Vote;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrganVoteRule
 *
 * @ORM\Table(name="organ_voterule")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Vote\OrganVoteRuleRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="rule_type", type="string")
 * @ORM\DiscriminatorMap({})
 */
class OrganVoteRule
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
     * @ORM\Column(type="string", length=255)
     *
     */
    protected $name;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Responsability")
     *
     */
    protected $reportResponsability;
   

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\OrganType")
     *
     */
    protected $concernedOrganType;


    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Text\TextGroup", inversedBy="organVoteRules")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $textGroup;




    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
