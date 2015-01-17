<?php
namespace AppBundle;


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
