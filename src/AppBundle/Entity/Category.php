<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Category.
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="CategoryRepository")
 */
class Category {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Title of the category.
     *
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\NotNull
     */
    private $title;

    /**
     * @var Page
     *
     * @ORM\OneToMany(targetEntity="Page", mappedBy="category", cascade="persist")
     */
    private $pages;

    /**
     * Short Description.
     *
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * Is active and visible.
     *
     * @var bool
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=true)
     */
    private $isActive;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return Page
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * @param Page $pages
     */
    public function setPages($pages)
    {
        $this->pages = $pages;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return boolean
     */
    public function isIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param boolean $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->title;
    }
}