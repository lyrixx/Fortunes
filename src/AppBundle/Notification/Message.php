<?php

namespace AppBundle\Notification;

class Message
{
    private $text;
    private $date;

    public function __construct(string $text, \DateTimeInterface $date)
    {
        $this->text = $text;
        $this->date = $date;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }
}