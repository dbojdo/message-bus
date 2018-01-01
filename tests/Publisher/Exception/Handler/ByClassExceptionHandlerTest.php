<?php

namespace Webit\MessageBus\Publisher\Exception\Handler;

use Prophecy\Prophecy\ObjectProphecy;
use Webit\MessageBus\AbstractTestCase;
use Webit\MessageBus\Publisher\Exception\CannotPublishMessageException;
use Webit\MessageBus\Publisher\Exception\UnsupportedMessageTypeException;

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
        $exception = CannotPublishMessageException::forMessage($this->randomMessage());
        $this->unsupportedMessageTypeHandler->handle($exception)->shouldNotBeCalled();
        $this->otherExceptionHadler->handle($exception)->shouldBeCalled();

        $this->handler->handle($exception);
    }

    /**
     * @test
     * @expectedException \Webit\MessageBus\Publisher\Exception\CannotPublishMessageException
     */
    public function itThrowsExceptionByDefault()
    {
        $handler = new ByClassExceptionHandler();
        $handler->handle(CannotPublishMessageException::forMessage($this->randomMessage()));
    }
}
