<?php

namespace Webit\MessageBus\Consumer;

use Psr\Log\LoggerInterface;
use Webit\MessageBus\Consumer;
use Webit\MessageBus\Message;

final class LoggingConsumer implements Consumer
{
    /** @var LoggerInterface */
    private $logger;

    /** @var Consumer */
    private $consumer;

    public function __construct(LoggerInterface $logger, Consumer $consumer = null)
    {
        $this->logger = $logger;
        $this->consumer = $consumer ?: new VoidConsumer();
    }

    /**
     * @inheritdoc
     */
    public function consume(Message $message)
    {
        $this->logger->info(
            sprintf('Consuming message of type "%s".', $message->type()),
            ['message' => $message]
        );
        $this->consumer->consume($message);
    }
}
