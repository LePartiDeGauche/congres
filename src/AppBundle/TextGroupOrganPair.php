<?php

namespace AppBundle;

use AppBundle\Entity\Text\TextGroup;
use AppBundle\Entity\Organ\Organ;

class TextGroupOrganPair {
    private $textGroup;
    private $organ;

    public function __construct(TextGroup $textGroup, Organ $organ)
    {
        $this->textGroup = $textGroup;
        $this->organ = $organ;
    }

    public function getTextGroup()
    {
        return $this->textGroup;
    }
    public function getOrgan()
    {
        return $this->organ;
    }


}
?>
