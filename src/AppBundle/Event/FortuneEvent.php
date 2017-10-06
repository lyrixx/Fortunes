<?php

namespace AppBundle\Events;

use AppBundle\Entity\Fortune;

class FortuneEvent
{
    private $fortune;

    public function __construct(Fortune $fortune)
    {
        $this->fortune = $fortune;
    }

    public function getFortune(): Fortune
    {
        return $this->fortune;
    }

    public function setFortune(Fortune $fortune): void
    {
        $this->fortune = $fortune;
    }
}