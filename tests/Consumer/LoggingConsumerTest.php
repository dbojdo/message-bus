<?php

namespace Webit\MessageBus\Consumer;

use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Log\LoggerInterface;
use Webit\MessageBus\AbstractTestCase;
use Webit\MessageBus\Consumer;

class LoggingConsumerTest extends AbstractTestCase
{
    /** @var LoggerInterface|ObjectProphecy */
    private $logger;

    /** @var Consumer|ObjectProphecy */
    private $innerConsumer;

    /** @var LoggingConsumer */
    private $consumer;

    protected function setUp()
    {
        $this->logger = $this->prophesize(LoggerInterface::class);
        $this->innerConsumer = $this->prophesize(Consumer::class);
        $this->consumer = new LoggingConsumer($this->logger->reveal(), $this->innerConsumer->reveal());
    }

    /**
     * @test
     */
    public function itLogsConsumption()
    {
        $message = $this->randomMessage();
        $this->logger->info(Argument::containingString($message->type()), ['message' => $message])->shouldBeCalled();
        $this->innerConsumer->consume($message)->shouldBeCalled();

        $this->consumer->consume($message);
    }
}
