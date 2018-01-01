<?php

namespace Webit\MessageBus\Consumer\Exception\Handler;

use Prophecy\Prophecy\ObjectProphecy;
use Webit\MessageBus\AbstractTestCase;
use Webit\MessageBus\Consumer\Exception\CannotConsumeMessageException;
use Webit\MessageBus\Publisher;

class PublishingExceptionHandlerTest extends AbstractTestCase
{
    /** @var Publisher|ObjectProphecy */
    private $publisher;

    /** @var ExceptionHandler|ObjectProphecy */
    private $innerHandler;

    /** @var PublishingExceptionHandler */
    private $handler;

    protected function setUp()
    {
        $this->publisher = $this->prophesize(Publisher::class);
        $this->innerHandler = $this->prophesize(ExceptionHandler::class);
        $this->handler = new PublishingExceptionHandler(
            $this->publisher->reveal(),
            $this->innerHandler->reveal()
        );
    }

    /**
     * @test
     */
    public function itPublishesMessage()
    {
        $exception = CannotConsumeMessageException::forMessage($this->randomMessage());
        $this->publisher->publish($exception->messageBusMessage())->shouldBeCalled();
        $this->innerHandler->handle($exception)->shouldBeCalled();

        $this->handler->handle($exception);
    }

    /**
     * @test
     */
    public function itIgnoresExceptionByDefault()
    {
        $exception = CannotConsumeMessageException::forMessage($this->randomMessage());
        $this->publisher->publish($exception->messageBusMessage())->shouldBeCalled();

        $handler = new PublishingExceptionHandler($this->publisher->reveal());

        $handler->handle($exception);
    }
}
