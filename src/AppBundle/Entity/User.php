<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
final class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * The collection of instances the user is member of.
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Instance", inversedBy="users")
     * @ORM\JoinTable(name="users_instances")
     */
    private $instances;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        // As we removed the username field from forms, we do this so
        // FOSUserBundle validation does not complain about empty username.
        $this->username = 'username';

        // Initialize collection
        $this->instances = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set email, and set username at same time.
     * @param string $email Email
     */
    public function setEmail($email)
    {
        $this->setUsername($email);

        return parent::setEmail($email);
    }
}
