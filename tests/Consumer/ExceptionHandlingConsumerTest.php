<?php

namespace Webit\MessageBus\Consumer;

use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Webit\MessageBus\AbstractTestCase;
use Webit\MessageBus\Consumer;
use Webit\MessageBus\Consumer\Exception\CannotConsumeMessageException;

class ExceptionHandlingConsumerTest extends AbstractTestCase
{
    /** @var Consumer|ObjectProphecy */
    private $innerConsumer;

    /** @var Consumer\Exception\Handler\ExceptionHandler|ObjectProphecy */
    private $exceptionHandler;

    /** @var ExceptionHandlingConsumer */
    private $consumer;

    protected function setUp()
    {
        $this->innerConsumer = $this->prophesize(Consumer::class);
        $this->exceptionHandler = $this->prophesize(Consumer\Exception\Handler\ExceptionHandler::class);
        $this->consumer = new ExceptionHandlingConsumer(
            $this->innerConsumer->reveal(),
            $this->exceptionHandler->reveal()
        );
    }

    /**
     * @test
     */
    public function itConsumesAMessage()
    {
        $message = $this->randomMessage();

        $this->innerConsumer->consume($message)->shouldBeCalled();
        $this->exceptionHandler->handle(Argument::any())->shouldNotBeCalled();
        $this->consumer->consume($message);
    }

    /**
     * @test
     */
    public function itHandlesException()
    {
        $exception = CannotConsumeMessageException::forMessage($message = $this->randomMessage());
        $this->innerConsumer->consume($message)->willThrow($exception);
        $this->exceptionHandler->handle($exception)->shouldBeCalled();
        $this->consumer->consume($message);
    }

    /**
     * @test
     * @expectedException \Webit\MessageBus\Consumer\Exception\CannotConsumeMessageException
     */
    public function itThrowsExceptionByDefault()
    {
        $exception = CannotConsumeMessageException::forMessage($message = $this->randomMessage());
        $this->innerConsumer->consume($message)->willThrow($exception);

        $consumer = new ExceptionHandlingConsumer($this->innerConsumer->reveal());
        $consumer->consume($message);
    }
}
