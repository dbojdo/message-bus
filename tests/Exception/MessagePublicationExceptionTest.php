<?php

namespace Webit\MessageBus\Exception;

use Webit\MessageBus\AbstractTestCase;

class MessagePublicationExceptionTest extends AbstractTestCase
{
    /**
     * @test
     */
    public function shouldBeCreatedForMessage()
    {
        $message = $this->randomMessage();
        $previous = $this->prophesize(\Exception::class)->reveal();
        $code = $this->randomPositiveInt();

        $exception = MessagePublicationException::forMessage($message, $code, $previous);
        $this->assertInstanceOf(MessagePublicationException::class, $exception);
        $this->assertSame($message, $exception->messageBusMessage());
        $this->assertSame($previous, $exception->getPrevious());
        $this->assertSame($code, $exception->getCode());
    }
}
