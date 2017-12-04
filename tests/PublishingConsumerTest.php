<?php

namespace Webit\MessageBus;

use Prophecy\Prophecy\ObjectProphecy;

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
}
