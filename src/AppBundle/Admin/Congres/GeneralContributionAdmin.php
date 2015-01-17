<?php

namespace AppBundle\Admin\Congres;

use Sonata\AdminBundle\Route\RouteCollection;

class GeneralContributionAdmin extends ContributionAdmin
{
    protected $baseRouteName = 'congres/contributions/generales';
    protected $baseRoutePattern = 'congres/contributions/generales';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
    }
}
