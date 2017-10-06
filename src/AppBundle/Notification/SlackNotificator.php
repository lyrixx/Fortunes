<?php

namespace AppBundle\Notification;

use CL\Slack\Transport\ApiClientInterface;
use Psr\Log\LoggerInterface;
use CL\Slack\Payload\ChatPostMessagePayload;

class SlackNotificator implements NotificatorInterface
{
    private $apiSlack;
    private $logger;
    private $isSlackNotifEnabled;
    private $channelName;
    private $username;
    private $icon;

    public function __construct(ApiClientInterface $apiSlack, LoggerInterface $logger, string $isSlackNotifEnabled, string $channelName, string $username, string $icon)
    {
        $this->apiSlack = $apiSlack;
        $this->logger = $logger;
        $this->isSlackNotifEnabled = $isSlackNotifEnabled;
        $this->channelName = $channelName;
        $this->username = $username;
        $this->icon = $icon;
    }

    public function notify(Message $message): void
    {
        if (!$this->isSlackNotifEnabled) {
            return;
        }

        $payload = $this->createPostMessageSlack($message->getText());
        try {
            $response = $this->apiSlack->send($payload);
            if (null !== $response->getError()) {
                // to change
                throw new \Exception($response->getError());
            }
        } catch (\Exception $e) {
            $this->logger->error(
                'Error sending Slack notification : {error}',
                [
                    'error' => $e->getMessage(),
                ]
            );
        }
    }

    public function createPostMessageSlack(string $textMessage): ChatPostMessagePayload
    {
        $payload = new ChatPostMessagePayload();
        $payload->setChannel($this->channelName);
        $payload->setUsername($this->username);
        $payload->setIconEmoji($this->icon);
        $payload->setText($textMessage);

        return $payload;
    }
}