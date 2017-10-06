<?php

namespace AppBundle\EventListener;

use AppBundle\Events\DomainEvents\DomainEvents;
use AppBundle\Events\FortuneEvent;
use AppBundle\Notification\Message;
use AppBundle\Notification\NotificatorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class NotificatorListener implements EventSubscriberInterface
{
    private $notificator;

    public function __construct(NotificatorInterface $notificator)
    {
        $this->notificator = $notificator;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            DomainEvents::FORTUNE_CREATED => 'notify'
        ];
    }

    public function notify(FortuneEvent $event) : void
    {
        $fortune = $event->getFortune();

        $this->notificator->notify(
            new Message(
                $fortune->getQuotes(),
                $fortune->getCreatedAt()
            )
        );
    }
}