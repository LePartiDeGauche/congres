<?php

namespace AppBundle\Entity\Process;

use Doctrine\ORM\Mapping as ORM;

/**
 * ParticipationRuleTerm
 *
 * @ORM\Table(name="process_participation_rule_term")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Process\ParticipationRuleTermRepository")
 */
class ParticipationRuleTerm
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
     * @var AppBundle\Entity\Responsability
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Responsability")
     */
    private $responsability;

    /**
     * @var AppBundle\Entity\Entity\Organ\OrganType
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Organ\OrganType")
     */
    private $organType;

    /**
     * @var AppBundle\Entity\Entity\Organ\OrganType
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Process\ParticipationRule",
     *                inversedBy="participationRuleTerms",
     *                cascade={"persist"})
     */
    private $participationRule;

    public function __toString()
    {
        return '[' . $this->responsability . ' / ' . $this->organType . ']';
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
     * Set responsability
     *
     * @param \AppBundle\Entity\Responsability $responsability
     *
     * @return ParticipationRuleTerm
     */
    public function setResponsability(\AppBundle\Entity\Responsability $responsability = null)
    {
        $this->responsability = $responsability;

        return $this;
    }

    /**
     * Get responsability
     *
     * @return \AppBundle\Entity\Responsability
     */
    public function getResponsability()
    {
        return $this->responsability;
    }

    /**
     * Set organType
     *
     * @param \AppBundle\Entity\Organ\OrganType $organType
     *
     * @return ParticipationRuleTerm
     */
    public function setOrganType(\AppBundle\Entity\Organ\OrganType $organType = null)
    {
        $this->organType = $organType;

        return $this;
    }

    /**
     * Get organType
     *
     * @return \AppBundle\Entity\Organ\OrganType
     */
    public function getOrganType()
    {
        return $this->organType;
    }

    /**
     * Set participationRule
     *
     * @param \AppBundle\Entity\Process\ParticipationRule $participationRule
     *
     * @return ParticipationRuleTerm
     */
    public function setParticipationRule(\AppBundle\Entity\Process\ParticipationRule $participationRule = null)
    {
        $this->participationRule = $participationRule;

        return $this;
    }

    /**
     * Get participationRule
     *
     * @return \AppBundle\Entity\Process\ParticipationRule
     */
    public function getParticipationRule()
    {
        return $this->participationRule;
    }
}
