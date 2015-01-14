<?php

namespace AppBundle\Admin\Congres;

use AppBundle\Entity\Congres\Contribution;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBUndle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
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
