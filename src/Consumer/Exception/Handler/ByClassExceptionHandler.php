<?php

namespace Webit\MessageBus\Consumer\Exception\Handler;

use Webit\MessageBus\Consumer\Exception\MessageConsumptionException;
use Webit\MessageBus\Consumer\Exception\UnsupportedMessageTypeException;

final class ByClassExceptionHandler implements ExceptionHandler
{
    /** @var ExceptionHandler */
    private $unsupportedMessageHandler;

    /** @var ExceptionHandler */
    private $cannotConsumeMessageHandler;

    public function __construct(
        ExceptionHandler $unsupportedMessageHandler = null,
        ExceptionHandler $cannotPublishMessageHandler = null
    ) {
        $this->unsupportedMessageHandler = $unsupportedMessageHandler ?: new ThrowingExceptionHandler();
        $this->cannotConsumeMessageHandler = $cannotPublishMessageHandler ?: new ThrowingExceptionHandler();
    }

    /**
     * @inheritdoc
     */
    public function handle(MessageConsumptionException $exception)
    {
        switch (true) {
            case $exception instanceof UnsupportedMessageTypeException:
                $this->unsupportedMessageHandler->handle($exception);
                break;
            default:
                $this->cannotConsumeMessageHandler->handle($exception);
        }
    }
}
