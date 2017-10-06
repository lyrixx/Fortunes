<?php

namespace AppBundle\Notification;

interface NotificatorInterface
{
    public function notify(Message $message): void;
}