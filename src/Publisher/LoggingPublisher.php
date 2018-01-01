<?php

namespace Webit\MessageBus\Publisher;

use Psr\Log\LoggerInterface;
use Webit\MessageBus\Message;
use Webit\MessageBus\Publisher;

final class LoggingPublisher implements Publisher
{
    /** @var Publisher */
    private $publisher;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(Publisher $publisher, LoggerInterface $logger)
    {
        $this->publisher = $publisher;
        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     */
    public function publish(Message $message)
    {
        $this->logger->info(
            sprintf('Publishing message of type "%s"', $message->type()),
            ['message' => $message]
        );
        $this->publisher->publish($message);
    }
}
