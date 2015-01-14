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
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
    }

    protected $baseRouteName = 'congres/contributions/generales';
    protected $baseRoutePattern = 'congres/contributions/generales';
}
