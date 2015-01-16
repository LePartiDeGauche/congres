<?php
namespace AppBundle;

use AppBundle\Entity\Congres\Contribution;
use Symfony\Component\Security\Core\Authorization\Voter\AbstractVoter;
use Symfony\Component\Security\Core\User\UserInterface;

final class RouteString
{
    private $route;

    public function getRoute()
    {
        return $this->route;
    }

    public function __construct($route)
    {
        $this->route = $route;
    }

}
