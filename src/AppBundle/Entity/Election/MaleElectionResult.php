<?php

namespace AppBundle\Entity\Election;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Election\ElectionResult;

/**
 * ElectionResult
 *
 * @ORM\Table(name="election_male_result")
 * @ORM\Entity
 */
class MaleElectionResult extends ElectionResult
{
}
