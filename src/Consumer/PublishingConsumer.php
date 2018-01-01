<?php

namespace Webit\MessageBus\Consumer;

use Webit\MessageBus\Consumer;
use Webit\MessageBus\Consumer\Exception\CannotConsumeMessageException;
use Webit\MessageBus\Consumer\Exception\UnsupportedMessageTypeException;
use Webit\MessageBus\Message;
use Webit\MessageBus\Publisher;
use Webit\MessageBus\Publisher\Exception\MessagePublicationException;
use Webit\MessageBus\Publisher\Exception\UnsupportedMessageTypeException as PublisherUnsupportedMessageTypeException;

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
        }
        catch (PublisherUnsupportedMessageTypeException $e) {
            throw UnsupportedMessageTypeException::forMessage($message, 0, $e);
        }
        catch (MessagePublicationException $e) {
            throw CannotConsumeMessageException::forMessage($message, 0, $e);
        }
    }
}
