<?php

namespace Webit\MessageBus\Exception;

use Webit\MessageBus\AbstractTestCase;

class MessageConsumptionExceptionTest extends AbstractTestCase
{
    /**
     * @test
     */
    public function shouldBeCreatedForMessage()
    {
        $message = $this->randomMessage();
        $previous = $this->prophesize(\Exception::class)->reveal();
        $code = $this->randomPositiveInt();

        $exception = MessageConsumptionException::forMessage($message, $code, $previous);
        $this->assertInstanceOf(MessageConsumptionException::class, $exception);
        $this->assertSame($message, $exception->messageBusMessage());
        $this->assertSame($previous, $exception->getPrevious());
        $this->assertSame($code, $exception->getCode());
    }
}
