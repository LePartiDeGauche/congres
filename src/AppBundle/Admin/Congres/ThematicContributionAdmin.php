<?php

namespace AppBundle\Admin\Congres;

use Sonata\AdminBundle\Route\RouteCollection;

class ThematicContributionAdmin extends ContributionAdmin
{
    protected $baseRouteName = 'congres/contributions/thematiques';
    protected $baseRoutePattern = 'congres/contributions/thematiques';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
    }
}
