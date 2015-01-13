<?php

namespace AppBundle\Admin\Congres;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBUndle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class GeneralContributionAdmin extends ContributionAdmin
{
    protected $baseRouteName = 'congres/contributions/generales';
    protected $baseRoutePattern = 'congres/contributions/generales';
}
