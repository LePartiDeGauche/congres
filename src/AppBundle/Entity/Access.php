<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Access.
 *
 * @ORM\Table(name="access")
 * @ORM\Entity
 */
class Access
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
     * @var \DateTime
     *
     * @ORM\Column(name="begin", type="datetime")
     */
    private $begin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end", type="datetime")
     */
    private $end;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="route", type="string")
     */
    private $route;

    public function __construct()
    {
        $this->begin = new \DateTime();
        $this->end = new \DateTime();
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
     * Set begin.
     *
     * @param \DateTime $begin
     *
     * @return Access
     */
    public function setBegin($begin)
    {
        $this->begin = $begin;

        return $this;
    }

    /**
     * Get begin.
     *
     * @return \DateTime
     */
    public function getBegin()
    {
        return $this->begin;
    }

    /**
     * Set end.
     *
     * @param \DateTime $end
     *
     * @return Access
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get end.
     *
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set route.
     *
     * @param string $route
     *
     * @return Access
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route.
     *
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }
}
