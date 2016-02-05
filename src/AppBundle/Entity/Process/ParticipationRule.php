<?php

namespace AppBundle\Entity\Process;

use Doctrine\ORM\Mapping as ORM;

/**
 * ParticipationRule
 *
 * @ORM\Table(name="process_participation_rule")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Process\ParticipationRuleRepository")
 */
class ParticipationRule
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
     * @var \Doctrine\Common\Collections\ArrayCollection()
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Process\ParticipationRuleTerm",
     *                mappedBy="participationRule",
     *                cascade={"persist"})
     */
    private $participationRuleTerms;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->participationRuleTerms = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();
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
     *
     * @return ParticipationRule
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
     * Add participationRuleTerm
     *
     * @param \AppBundle\Entity\Process\ParticipationRuleTerm $participationRuleTerm
     *
     * @return ParticipationRule
     */
    public function addParticipationRuleTerm(\AppBundle\Entity\Process\ParticipationRuleTerm $participationRuleTerm)
    {
        $participationRuleTerm->setParticipationRule($this);
        $this->participationRuleTerms[] = $participationRuleTerm;

        return $this;
    }

    /**
     * Remove participationRuleTerm
     *
     * @param \AppBundle\Entity\Process\ParticipationRuleTerm $participationRuleTerm
     */
    public function removeParticipationRuleTerm(\AppBundle\Entity\Process\ParticipationRuleTerm $participationRuleTerm)
    {
        $participationRuleTerm->setParticipationRule(null);
        $this->participationRuleTerms->removeElement($participationRuleTerm);
    }

    /**
     * Get participationRuleTerms
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getParticipationRuleTerms()
    {
        return $this->participationRuleTerms;
    }
}
