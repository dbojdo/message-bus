<?php

namespace Webit\MessageBus\Consumer;

use Prophecy\Prophecy\ObjectProphecy;
use Webit\MessageBus\AbstractTestCase;
use Webit\MessageBus\Consumer\Exception\CannotConsumeMessageException;
use Webit\MessageBus\Consumer\Exception\UnsupportedMessageTypeException;
use Webit\MessageBus\Publisher;
use Webit\MessageBus\Publisher\Exception\CannotPublishMessageException;
use Webit\MessageBus\Publisher\Exception\UnsupportedMessageTypeException as PublisherUnsupportedMessageTypeException;

class PublishingConsumerTest extends AbstractTestCase
{
    /** @var Publisher|ObjectProphecy */
    private $publisher;

    /** @var PublishingConsumer */
    private $sut;

    protected function setUp()
    {
        $this->publisher = $this->prophesize(Publisher::class);
        $this->sut = new PublishingConsumer($this->publisher->reveal());
    }

    /**
     * @test
     */
    public function itPublishesConsumedMessage()
    {
        $message = $this->randomMessage();
        $this->publisher->publish($message)->shouldBeCalled();

        $this->sut->consume($message);
    }

    /**
     * @test
     */
    public function itWrapsUnsupportedMessageTypePublicationException()
    {
        $message = $this->randomMessage();

        $exception = PublisherUnsupportedMessageTypeException::forMessage($message);
        $this->publisher->publish($message)->willThrow($exception);
        $this->expectException(UnsupportedMessageTypeException::class);

        $this->sut->consume($message);
    }

    /**
     * @test
     */
    public function itWrapsPublicationExceptionWithConsumptionOne()
    {
        $message = $this->randomMessage();

        $exception = CannotPublishMessageException::forMessage($message);
        $this->publisher->publish($message)->willThrow($exception);
        $this->expectException(CannotConsumeMessageException::class);
        
        $this->sut->consume($message);
    }
}
