<?php

namespace Webit\MessageBus\Consumer;

use Webit\MessageBus\Consumer;
use Webit\MessageBus\Consumer\Exception\Handler\ExceptionHandler;
use Webit\MessageBus\Consumer\Exception\Handler\ThrowingExceptionHandler;
use Webit\MessageBus\Consumer\Exception\MessageConsumptionException;
use Webit\MessageBus\Message;

final class ExceptionHandlingConsumer implements Consumer
{
    /** @var Consumer */
    private $consumer;

    /** @var ExceptionHandler */
    private $exceptionHandler;

    public function __construct(Consumer $consumer, ExceptionHandler $exceptionHandler = null)
    {
        $this->consumer = $consumer;
        $this->exceptionHandler = $exceptionHandler ?: new ThrowingExceptionHandler();
    }

    /**
     * @inheritdoc
     */
    public function consume(Message $message)
    {
        try {
            $this->consumer->consume($message);
        } catch (MessageConsumptionException $e) {
            $this->exceptionHandler->handle($e);
        }
    }
}
