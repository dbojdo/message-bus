<?php

namespace Webit\MessageBus\Consumer\Exception\Handler;

use Psr\Log\LoggerInterface;
use Webit\MessageBus\AbstractTestCase;
use Webit\MessageBus\Consumer\Exception\CannotConsumeMessageException;

class LoggingExceptionHandlerTest extends AbstractTestCase
{
    /** @var LoggerInterface */
    private $logger;

    /** @var ExceptionHandler */
    private $innerHandler;

    /** @var LoggingExceptionHandler */
    private $handler;

    protected function setUp()
    {
        $this->logger = $this->prophesize(LoggerInterface::class);
        $this->innerHandler = $this->prophesize(ExceptionHandler::class);
        $this->handler = new LoggingExceptionHandler(
            $this->logger->reveal(),
            $this->innerHandler->reveal()
        );
    }

    /**
     * @test
     */
    public function itLogsException()
    {
        $exception = CannotConsumeMessageException::forMessage($message = $this->randomMessage());
        $this->logger->error(
            $exception->getMessage(),
            ['exception' => $exception, 'message' => $message]
        )->shouldBeCalled();

        $this->innerHandler->handle($exception)->shouldBeCalled();
        $this->handler->handle($exception);
    }

    /**
     * @test
     * @expectedException \Webit\MessageBus\Consumer\Exception\CannotConsumeMessageException
     */
    public function itRethrowsExceptionByDefault()
    {
        $exception = CannotConsumeMessageException::forMessage($message = $this->randomMessage());
        $this->logger->error(
            $exception->getMessage(),
            ['exception' => $exception, 'message' => $message]
        )->shouldBeCalled();

        $handler = new LoggingExceptionHandler($this->logger->reveal());
        $handler->handle($exception);
    }
}
