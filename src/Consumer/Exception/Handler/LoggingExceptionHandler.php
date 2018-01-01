<?php

namespace Webit\MessageBus\Consumer\Exception\Handler;

use Psr\Log\LoggerInterface;
use Webit\MessageBus\Consumer\Exception\MessageConsumptionException;

final class LoggingExceptionHandler implements ExceptionHandler
{
    /** @var LoggerInterface */
    private $logger;

    /** @var ExceptionHandler */
    private $innerHandler;

    public function __construct(LoggerInterface $logger, ExceptionHandler $innerHandler = null)
    {
        $this->logger = $logger;
        $this->innerHandler = $innerHandler ?: new ThrowingExceptionHandler();
    }

    /**
     * @inheritdoc
     */
    public function handle(MessageConsumptionException $exception)
    {
        $this->logger->error(
            $exception->getMessage(),
            [
                'message' => $exception->messageBusMessage(),
                'exception' => $exception
            ]
        );

        $this->innerHandler->handle($exception);
    }
}
