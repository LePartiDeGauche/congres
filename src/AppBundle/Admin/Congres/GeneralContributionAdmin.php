<?php

namespace AppBundle\Admin\Congres;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBUndle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
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
