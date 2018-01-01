<?php

namespace Webit\MessageBus\Consumer\Exception\Handler;

use Webit\MessageBus\Publisher;
use Webit\MessageBus\Consumer\Exception\MessageConsumptionException;

final class PublishingExceptionHandler implements ExceptionHandler
{
    /** @var Publisher */
    private $publisher;

    /** @var ExceptionHandler */
    private $innerHandler;

    public function __construct(Publisher $publisher, ExceptionHandler $innerHandler = null)
    {
        $this->publisher = $publisher;
        $this->innerHandler = $innerHandler ?: new IgnoringExceptionHandler();
    }

    /**
     * @inheritdoc
     */
    public function handle(MessageConsumptionException $exception)
    {
        $this->publisher->publish($exception->messageBusMessage());
        $this->innerHandler->handle($exception);
    }
}
