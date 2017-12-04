<?php

namespace Webit\MessageBus;

class PublishingConsumer implements Consumer
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
        $this->publisher->publish($message);
    }
}