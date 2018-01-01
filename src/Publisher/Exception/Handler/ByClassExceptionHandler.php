<?php

namespace Webit\MessageBus\Publisher\Exception\Handler;

use Webit\MessageBus\Publisher\Exception\MessagePublicationException;
use Webit\MessageBus\Publisher\Exception\UnsupportedMessageTypeException;

final class ByClassExceptionHandler implements ExceptionHandler
{
    /** @var ExceptionHandler */
    private $unsupportedMessageHandler;

    /** @var ExceptionHandler */
    private $cannotPublishMessageHandler;

    public function __construct(
        ExceptionHandler $unsupportedMessageHandler = null,
        ExceptionHandler $cannotPublishMessageHandler = null
    ) {
        $this->unsupportedMessageHandler = $unsupportedMessageHandler ?: new ThrowingExceptionHandler();
        $this->cannotPublishMessageHandler = $cannotPublishMessageHandler ?: new ThrowingExceptionHandler();
    }

    /**
     * @inheritdoc
     */
    public function handle(MessagePublicationException $exception)
    {
        switch (true) {
            case $exception instanceof UnsupportedMessageTypeException:
                $this->unsupportedMessageHandler->handle($exception);
                break;
            default:
                $this->cannotPublishMessageHandler->handle($exception);
        }
    }
}
