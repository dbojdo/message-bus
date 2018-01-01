<?php

namespace Webit\MessageBus\Publisher;

use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Webit\MessageBus\AbstractTestCase;
use Webit\MessageBus\Publisher;
use Webit\MessageBus\Publisher\Exception\CannotPublishMessageException;
use Webit\MessageBus\Publisher\Exception\Handler\ExceptionHandler;

class ExceptionHandlingPublisherTest extends AbstractTestCase
{
    /** @var Publisher|ObjectProphecy */
    private $innerPublisher;

    /** @var ExceptionHandler|ObjectProphecy */
    private $exceptionHandler;

    /** @var ExceptionHandlingPublisher */
    private $publisher;

    protected function setUp()
    {
        $this->innerPublisher = $this->prophesize(Publisher::class);
        $this->exceptionHandler = $this->prophesize(ExceptionHandler::class);
        $this->publisher = new ExceptionHandlingPublisher(
            $this->innerPublisher->reveal(),
            $this->exceptionHandler->reveal()
        );
    }

    /**
     * @test
     */
    public function itPublishesTheMessage()
    {
        $message = $this->randomMessage();

        $this->innerPublisher->publish($message)->shouldBeCalled();
        $this->exceptionHandler->handle(Argument::any())->shouldNotBeCalled();

        $this->publisher->publish($message);
    }

    /**
     * @test
     */
    public function itHandlesException()
    {
        $message = $this->randomMessage();

        $this->innerPublisher->publish($message)->willThrow($e = CannotPublishMessageException::forMessage($message));
        $this->exceptionHandler->handle($e)->shouldBeCalled();

        $this->publisher->publish($message);
    }

    /**
     * @test
     * @expectedException \Webit\MessageBus\Publisher\Exception\CannotPublishMessageException
     */
    public function itThrowsExceptionByDefault()
    {
        $message = $this->randomMessage();

        $this->innerPublisher->publish($message)->willThrow($e = CannotPublishMessageException::forMessage($message));

        $publisher = new ExceptionHandlingPublisher($this->innerPublisher->reveal());
        $publisher->publish($message);
    }
}
