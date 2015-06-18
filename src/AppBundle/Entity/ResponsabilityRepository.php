<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Adherent;
use Doctrine\ORM\EntityRepository;

/**
 * ResponsabilityRepository.
 */
class ResponsabilityRepository extends EntityRepository
{
    protected $classname = 'AppBundle\Entity\Responsability';
}
