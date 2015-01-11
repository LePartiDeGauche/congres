<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
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
     * The adherent profile associated to the user.
     * @var Adherent
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Adherent", inversedBy="user")
     */
    protected $profile;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        // As we removed the username field from forms, we do this so
        // FOSUserBundle validation does not complain about empty username.
        $this->username = 'username';
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

    /**
     * Set profile, and set email at the same time.
     * @param Adherent $profile Profile
     */
    public function setProfile(Adherent $profile)
    {
        $this->profile = $profile;
        $this->setEmail($profile->getEmail());
    }

    /**
     * Get profile
     *
     * @return \AppBundle\Entity\Adherent
     */
    public function getProfile()
    {
        return $this->profile;
    }
}
