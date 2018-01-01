<?php

namespace Webit\MessageBus\Publisher\Exception\Handler;

use Prophecy\Prophecy\ObjectProphecy;
use Psr\Log\LoggerInterface;
use Webit\MessageBus\AbstractTestCase;
use Webit\MessageBus\Publisher\Exception\CannotPublishMessageException;

class LoggingExceptionHandlerTest extends AbstractTestCase
{
    /** @var LoggerInterface|ObjectProphecy */
    private $logger;

    /** @var ExceptionHandler|ObjectProphecy */
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
        $exception = CannotPublishMessageException::forMessage($message = $this->randomMessage());
        $this->logger->error(
            $exception->getMessage(),
            ['exception' => $exception, 'message' => $message]
        )->shouldBeCalled();

        $this->innerHandler->handle($exception)->shouldBeCalled();
        $this->handler->handle($exception);
    }

    /**
     * @test
     * @expectedException \Webit\MessageBus\Publisher\Exception\CannotPublishMessageException
     */
    public function itRethrowsExceptionByDefault()
    {
        $exception = CannotPublishMessageException::forMessage($message = $this->randomMessage());
        $this->logger->error(
            $exception->getMessage(),
            ['exception' => $exception, 'message' => $message]
        )->shouldBeCalled();

        $handler = new LoggingExceptionHandler($this->logger->reveal());
        $handler->handle($exception);
    }
}
