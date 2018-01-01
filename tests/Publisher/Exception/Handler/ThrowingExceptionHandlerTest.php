<?php

namespace Webit\MessageBus\Publisher\Exception\Handler;

use Webit\MessageBus\AbstractTestCase;
use Webit\MessageBus\Publisher\Exception\CannotPublishMessageException;
use Webit\MessageBus\Publisher\Exception\MessagePublicationException;

class ThrowingExceptionHandlerTest extends AbstractTestCase
{
    /**
     * @test
     */
    public function itRethrowsException()
    {
        $handler = new ThrowingExceptionHandler();

        $exception = CannotPublishMessageException::forMessage($this->randomMessage());
        try {
            $handler->handle($exception);
        } catch (MessagePublicationException $e) {
            $this->assertSame($exception, $e);
            return;
        }

        $this->assertTrue(false, 'Expected exception has not been thrown.');
    }
}
