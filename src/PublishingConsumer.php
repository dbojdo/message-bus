<?php

namespace Webit\MessageBus;

use Webit\MessageBus\Exception\MessageConsumptionException;
use Webit\MessageBus\Exception\MessagePublicationException;

final class PublishingConsumer implements Consumer
{
    /** @var Publisher */
    private $publisher;

    /**
     * PublishingConsumer constructor.
     * @param Publisher $publisher
     */
    public function __construct(Publisher $publisher)
    {
        $this->publisher = $publisher;
    }

    /**
     * @inheritdoc
     */
    public function consume(Message $message)
    {
        try {
            $this->publisher->publish($message);
        } catch (MessagePublicationException $e) {
            throw MessageConsumptionException::forMessage($message, 0, $e);
        }
    }
}
