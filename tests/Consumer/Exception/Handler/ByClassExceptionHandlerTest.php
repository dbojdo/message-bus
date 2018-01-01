<?php

namespace Webit\MessageBus\Consumer\Exception\Handler;

use Prophecy\Prophecy\ObjectProphecy;
use Webit\MessageBus\AbstractTestCase;
use Webit\MessageBus\Consumer\Exception\CannotConsumeMessageException;
use Webit\MessageBus\Consumer\Exception\UnsupportedMessageTypeException;

class ByClassExceptionHandlerTest extends AbstractTestCase
{
    /** @var ExceptionHandler|ObjectProphecy */
    private $unsupportedMessageTypeHandler;

    /** @var ExceptionHandler|ObjectProphecy */
    private $otherExceptionHadler;

    /** @var ByClassExceptionHandler */
    private $handler;

    protected function setUp()
    {
        $this->unsupportedMessageTypeHandler = $this->prophesize(ExceptionHandler::class);
        $this->otherExceptionHadler = $this->prophesize(ExceptionHandler::class);
        $this->handler = new ByClassExceptionHandler(
            $this->unsupportedMessageTypeHandler->reveal(),
            $this->otherExceptionHadler->reveal()
        );
    }

    /**
     * @test
     */
    public function itUsesUnsupportedMessageTypeHandler()
    {
        $exception = UnsupportedMessageTypeException::forMessage($this->randomMessage());
        $this->unsupportedMessageTypeHandler->handle($exception)->shouldBeCalled();
        $this->otherExceptionHadler->handle($exception)->shouldNotBeCalled();

        $this->handler->handle($exception);
    }

    /**
     * @test
     */
    public function itUsesOtherExceptionHandler()
    {
        $exception = CannotConsumeMessageException::forMessage($this->randomMessage());
        $this->unsupportedMessageTypeHandler->handle($exception)->shouldNotBeCalled();
        $this->otherExceptionHadler->handle($exception)->shouldBeCalled();

        $this->handler->handle($exception);
    }

    /**
     * @test
     * @expectedException \Webit\MessageBus\Consumer\Exception\CannotConsumeMessageException
     */
    public function itThrowsExceptionByDefault()
    {
        $handler = new ByClassExceptionHandler();
        $handler->handle(CannotConsumeMessageException::forMessage($this->randomMessage()));
    }
}
