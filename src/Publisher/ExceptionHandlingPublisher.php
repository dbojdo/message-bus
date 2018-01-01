<?php

namespace Webit\MessageBus\Publisher;

use Webit\MessageBus\Message;
use Webit\MessageBus\Publisher;
use Webit\MessageBus\Publisher\Exception\Handler\ExceptionHandler;
use Webit\MessageBus\Publisher\Exception\Handler\ThrowingExceptionHandler;
use Webit\MessageBus\Publisher\Exception\MessagePublicationException;

final class ExceptionHandlingPublisher implements Publisher
{
    /** @var Publisher */
    private $innerPublisher;

    /** @var ExceptionHandler */
    private $exceptionHandler;

    public function __construct(Publisher $innerPublisher, ExceptionHandler $exceptionHandler = null)
    {
        $this->innerPublisher = $innerPublisher;
        $this->exceptionHandler = $exceptionHandler ?: new ThrowingExceptionHandler();
    }

    /**
     * @inheritdoc
     */
    public function publish(Message $message)
    {
        try {
            $this->innerPublisher->publish($message);
        } catch (MessagePublicationException $e) {
            $this->exceptionHandler->handle($e);
        }
    }
}
