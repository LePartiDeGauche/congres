<?php

namespace AppBundle\Entity\Election;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Adherent;
use AppBundle\Entity\Responsability;

/**
 * Candidature.
 *
 * @ORM\Table(name="candidature")
 * @ORM\Entity
 */
class Candidature
{
    const STATUS_NEW = 'new';
    const STATUS_ADOPTED = 'adopted';
    const STATUS_REJECTED = 'rejected';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * The adherent who runs for the candidature.
     *
     * @var \AppBundle\Entity\Adherent
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Adherent")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\NotNull
     */
    private $author;

    /**
     * The responsability to which the adherent runs.
     *
     * @var \AppBundle\Entity\Responsability
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Responsability")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\NotNull
     */
    private $responsability;

    /**
     * The profession de foi.
     *
     * @var string
     *
     * @ORM\Column(name="professionfoi", type="text")
     *
     * @Assert\NotBlank
     * @Assert\Length(max=2500)
     */
    private $professionfoi;

    /**
     * The complement of profession de foi for those who already has
     * responsabilities.
     *
     * @var string
     *
     * @ORM\Column(name="professionfoicplt", type="text", nullable=true)
     *
     * @Assert\Length(max=1000)
     */
    private $professionfoicplt;


    /**
     * @var Boolean
     *
     * @ORM\Column(name="is_sortant", type="boolean")
     */
    private $isSortant;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="submit_date", type="datetime")
     *
     * @Assert\Date()
     */
    private $submitDate;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * Constructor.
     */
    public function __construct(Adherent $author = null)
    {
        $this->setAuthor($author);
        $this->setSubmitDate(new \DateTime('today'));
        $this->setStatus(self::STATUS_NEW);
        $this->setIsSortant(false);
    }

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
     * Set author.
     *
     * @param Adherent $author
     *
     * @return Candidature
     */
    public function setAuthor(Adherent $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author.
     *
     * @return Adherent
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set responsability.
     *
     * @param \stdClass $responsability
     *
     * @return Candidature
     */
    public function setResponsability(Responsability $responsability)
    {
        $this->responsability = $responsability;

        return $this;
    }

    /**
     * Get instance.
     *
     * @return \stdClass
     */
    public function getResponsability()
    {
        return $this->responsability;
    }

    /**
     * Set professionfoi.
     *
     * @param string $professionfoi
     *
     * @return Candidature
     */
    public function setProfessionfoi($professionfoi)
    {
        $this->professionfoi = $professionfoi;

        return $this;
    }

    /**
     * Get professionfoi.
     *
     * @return string
     */
    public function getProfessionfoi()
    {
        return $this->professionfoi;
    }

    /**
     * Is sortant
     *
     * @param boolean $isSortant
     *
     * @return Candidature
     */
    public function setIsSortant($isSortant)
    {
        $this->isSortant = $isSortant;

        return $this;
    }

    /**
     * Get is sortant
     *
     * @return string
     */
    public function getIsSortant()
    {
        return $this->isSortant;
    }

    /**
     * Set professionfoi complement
     *
     * @param string $professionfoi
     *
     * @return Candidature
     */
    public function setProfessionfoiCplt($professionfoicplt)
    {
        $this->professionfoicplt = $professionfoicplt;

        return $this;
    }

    /**
     * Get professionfoi.
     *
     * @return string
     */
    public function getProfessionfoiCplt()
    {
        return $this->professionfoicplt;
    }

    /**
     * Set submitDate.
     *
     * @param \DateTime $submitDate
     *
     * @return Candidature
     */
    public function setSubmitDate(\DateTime $submitDate)
    {
        $this->submitDate = $submitDate;

        return $this;
    }

    /**
     * Get submitDate.
     *
     * @return \DateTime
     */
    public function getSubmitDate()
    {
        return $this->submitDate;
    }

    /**
     * Set status.
     *
     * @param string $status
     *
     * @return Candidature
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
}
