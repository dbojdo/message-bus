<?php

namespace Webit\MessageBus;

use Prophecy\Prophecy\ObjectProphecy;
use Webit\MessageBus\Exception\MessageConsumptionException;
use Webit\MessageBus\Exception\MessagePublicationException;

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
    public function itWrapsPublicationExceptionWithConsumptionOne()
    {
        $message = $this->randomMessage();

        $exception = $this->prophesize(MessagePublicationException::class)->reveal();
        $this->publisher->publish($message)->willThrow($exception);
        $this->expectException(MessageConsumptionException::class);
        
        $this->sut->consume($message);
    }
}
