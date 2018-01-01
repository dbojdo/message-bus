<?php

namespace Webit\MessageBus\Publisher;

use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Log\LoggerInterface;
use Webit\MessageBus\AbstractTestCase;
use Webit\MessageBus\Publisher;

class LoggingPublisherTest extends AbstractTestCase
{
    /** @var LoggerInterface|ObjectProphecy */
    private $logger;

    /** @var Publisher|ObjectProphecy */
    private $innerPublisher;

    /** @var LoggingPublisher */
    private $publisher;

    protected function setUp()
    {
        $this->logger = $this->prophesize(LoggerInterface::class);
        $this->innerPublisher = $this->prophesize(Publisher::class);
        $this->publisher = new LoggingPublisher($this->innerPublisher->reveal(), $this->logger->reveal());
    }

    /**
     * @test
     */
    public function itLogsPublication()
    {
        $message = $this->randomMessage();
        $this->logger->info(Argument::containingString($message->type()), ['message' => $message])->shouldBeCalled();
        $this->innerPublisher->publish($message)->shouldBeCalled();

        $this->publisher->publish($message);
    }
}
